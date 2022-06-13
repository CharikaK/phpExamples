<?php

namespace Illuminate\Foundation\Auth;

namespace App\Http\Controllers\AF;

use Mail;
use App\Models\Role;
use App\Models\User;
use App\Models\Entity;
use App\Models\Question;
use App\Models\EntityType;
use App\Models\Programmes\Programme;
use Illuminate\Support\Str;
use App\Mail\PartnerConsent;
use App\Models\ClinicEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\AuthServiceProvider;
use App\Mail\PartnerEnrolledMedication;
use Illuminate\Auth\Passwords\PasswordBroker;

use App\Http\Requests\ChangePasswordSettingRequest;
use App\Http\Requests\ExpiredPasswordSettingRequest;
use App\Models\ClinicSatellite;
use App\Models\Emails\Clinic\SendClinicNewRegistrationEmail;
use App\Models\PatientEnrolment;
use App\Models\PatientEnrolmentContract;
use App\Models\PatientEntity;
use App\Models\ProgrammeContract;
use App\Models\Programmes\ProgrammeGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class EmailSwitch{

    public function showEmails(Request $request){
        $request->session()->forget('updated');
        // go to the settings file and get all the rows has the key ending with email
        $email_names = Setting::returnHasValue('_EMAIL');
        // return to the view as as array
        // view can get the key and the value, if the value is 1, then tick off
        return view('admin.emails-list',['live_emails'=>$email_names]);
    }

    // switch on / off email ssetting
    public function saveSettings(Request $request)
    {
        $request->session()->forget('updated');

        $old_values=[];
        $new_values=[];
        unset($old_values);
        unset($new_values);

        // record old values in array - get the values from the database -retreive all the records ending with _EMAIL
        $email_names = Setting::returnHasValue('_EMAIL');
        
        foreach($email_names as $email_name){
            $old_values[$email_name->key]=$email_name->value;
            
        }

        // record new values in an array - request keys            
        $keys=$request->keys();
        foreach($keys as $key){
            // take the checkbox value
            if($key!= "_token"){
                $requested_values[$key]=$request->input($key)=='on' ? "1":"0";
            }
        }

        if(!empty($requested_values)){
            $missing_keys=array_diff_key($old_values,$requested_values);       
       
            // update $requested with missing keys
            foreach($missing_keys as $key=>$value){
                // if the key does not exist in new values, then add the key with value 0 to $requested_values
                $requested_values[$key]= "0";
            }

        // compare arrays            
        $updated_values=array_diff_assoc($old_values,$requested_values);
        }

        // set all the values to 0
        foreach($email_names as $email_name){
           Setting::updateSettingValue($email_name->key,0);
        }
       
        // update the database table with request values
        foreach($keys as $key){            
            Setting::updateSettingValue($key,1);         
        }

        // now the $email_names has new values
        $email_names = Setting::returnHasValue('_EMAIL');
        $request->session()->put('updated',"Successfully saved changes");        

        return view('admin.emails-list',['live_emails'=>$email_names]); 
    }
}
