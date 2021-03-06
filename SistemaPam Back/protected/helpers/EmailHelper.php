<?php
class EmailHelper
{
    public static function sendEmail($subject, $body, $to){
       try
       {              
           $mail = new phpmailer();
           $mail->IsSMTP(); 
           $mail->SMTPAuth = true;
           $mail->SMTPSecure = 'ssl'; 
           $mail->Port = 465;
           $mail->SetFrom(Yii::app()->params['smtp']['username'], Yii::app()->params['smtp']['screenname']);
           $mail->AddAddress($to);
           $mail->Subject = $subject;
           $mail->Body = $body;
           $mail->IsHTML(true);
           $mail->CharSet = "UTF-8";

           $mail->Host = Yii::app()->params['smtp']['host'];
           $mail->Username = Yii::app()->params['smtp']['username'];
           $mail->Password = Yii::app()->params['smtp']['password'];

           if($mail->send()){      
               return true;
           }
           else{
                Errors::log('EmailHelpers::sendMail','Email no enviado',$to.' '.$subject);                  
               return false;
           }
       }
       catch(Exception $e){
           Errors::log('EmailHelpers::sendMail','Email no enviado',$to.' '.$subject.print_r($e,true));                
           return false;
       } 
    }
    
    public static function sendBenefit($to, $name, $title, $description, $qrLink, $barCodeLink, $code){
        
        $templateContent = array();
        
        $globalMergeVars = array(
            array(
                'name'=>'TITLE',
                'content'=>$title
            ),
            array(
                'name'=>'DESCRIPTION',
                'content'=>$description
            ),
            array(
                'name'=>'QR_LINK',
                'content'=>$qrLink
            ),
            array(
                'name'=>'BARCODE_LINK',
                'content'=>$barCodeLink
            ),
            array(
                'name'=>'CODE',
                'content'=>$code
            ),
        );
        
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('benefit', $templateContent, $to, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    
    public static function sendContact($to, $name, $message){
        
        $templateContent = array();
        
        $globalMergeVars = array(
            array(
                'name'=>'MESSAGE',
                'content'=>$message,
            )
        );
        
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('contact', $templateContent,$to, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    
    public static function sendNewAdministrator($to, $name, $email, $password){
        
        $templateContent = array();
        
        $globalMergeVars = array(
            array(
                'name'=>'EMAIL',
                'content'=>$email,
            ),
            array(
                'name'=>'PASSWORD',
                'content'=>$password,
            ),
            array(
                'name'=>'LINK',
                'content'=>Yii::app()->params['domain'].'/admin',
            )
        );
        
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('newAdministrator', $templateContent,$to, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    
    public static function sendNewClientUser($to, $name, $email, $password){
        
        $templateContent = array();
        
        $globalMergeVars = array(
            array(
                'name'=>'EMAIL',
                'content'=>$email,
            ),
            array(
                'name'=>'PASSWORD',
                'content'=>$password,
            ),
            array(
                'name'=>'LINK',
                'content'=>Yii::app()->params['domain'].'/comercios',
            )
        );
        
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('newClientUser', $templateContent,$to, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    public static function sendMandrillTemplate($template, $templateContent, $to, $name, $globalMergeVars, $mergeVars){
       $result = array();
       
       try
       {              
            $postData = array(
                'key'=>Yii::app()->params['mandrill']['key'],
                'template_name'=> $template,
                'template_content'=> $templateContent,
                'message'=> array(
                    'to'=> array(
                        array(
                            'email'=>$to,
                            'name'=>$name,
                            'type'=>'to'
                        )
                    ),
                    'merge'=>true,
                    'global_merge_vars'=>$globalMergeVars,
                    'merge_vars'=>$mergeVars
                ),
                'async'=>false
            );
            
            $postData = json_encode($postData);
            $result = HelperFunctions::postRequest(Yii::app()->params['mandrill']['endPoint'].'messages/send-template.json', $postData);
            $result = json_decode($result, true);
            
            if(isset($result['status']))
                if($result['status']=='sent')
                    return true;

            Errors::log('EmailHelpers::sendMandrillTemplate','Email no enviado a '.$to, print_r($result, true)); 
            return false;
       }
       catch(Exception $e){
           Errors::log('EmailHelpers::sendMandrillTemplate','Email no enviado a'.$to, print_r($result, true));                
           return false;
       } 
    }

    public static function sendConfirmation($user, $confirmationCode){
        
        $name = $user->first_name.' '.$user->last_name;
        
        $templateContent = array();
        
        $globalMergeVars = array(
            array(
                'name'=>'NAME',
                'content'=>$name
            ),
            array(
                'name'=>'LINK',
                'content'=>Yii::app()->params['domain'].'/Users/confirm?email='.$user->email.'&code='.$confirmationCode->code
            ),
        );
        
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('confirmation', $templateContent, $user->email, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    
    public static function sendChangePasswordEmail($user, $passwordChangeRequests){
        $name = explode('@', $user->email);
        $name = $name[0];
        if($user->first_name!=null && $user->first_name!='')
            $name = $user->first_name;
        if($user->last_name!=null && $user->last_name!='')
            $name .=" ".$user->last_name;
        
        $templateContent = array();
        
        
        $globalMergeVars = array(
            array('name'=>'DOMAIN',
                  'content'=>Yii::app()->params['domain']
                ),
            array(
                'name'=>'NAME',
                'content'=>$name
            ),
            array(
                'name'=>'LINK',
                'content'=>Yii::app()->params['domain'].'/users/processPasswordConfirmation?email='.$user->email.'&code='.$passwordChangeRequests->code
            )            
        );
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('ChangePassword', $templateContent, $user->email, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    public static function sendChangeEmailEmail($user, $emailChangeRequests){
        
        $name = explode('@', $user->email);
        $name = $name[0];
        if($user->first_name!=null && $user->first_name!='')
            $name = $user->first_name;
        if($user->last_name!=null && $user->last_name!='')
            $name .= $user->last_name;
        
        $templateContent = array();
        $globalMergeVars = array(
            array(
                'name'=>'NAME',
                'content'=>$user->first_name
            ),
            array(
                'name'=>'LINK',
                'content'=>Yii::app()->params['domain'].'/users/changeEmail?email='.$user->email.'&code='.$emailChangeRequests->code
            )
        );
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('ChangeEmail', $templateContent, $emailChangeRequests->email, $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
    
    public static function sendValuationEmail($user, $productHtml){
        
        $name = explode('@', $user->email);
        $name = $name[0];
        if($user->first_name!=null && $user->first_name!='')
            $name = $user->first_name;
        if($user->last_name!=null && $user->last_name!='')
            $name .= $user->last_name;
        
        $templateContent = array();
        $globalMergeVars = array(
            array(
                'name'=>'NAME',
                'content'=>$user->Name
            ),
            array(
                'name'=>'EMAIL',
                'content'=>$user->email
            ),
            array(
                'name'=>'HTML',
                'content'=>$productHtml
            )
        );
        $mergeVars = array();
        
        if(self::sendMandrillTemplate('valuationSent', $templateContent, Yii::app()->params['infoEmail'], $name, $globalMergeVars, $mergeVars))
            return true;
        
        return false;
    }
        
    public static function validateUruguayDocument($document){
        $document = preg_replace('/[^0-9]+/', "", $document);
        if(strlen($document)==8 || strlen($document)==7){
            $allButLastDigit = substr($document, 0, strlen($document)-1);
            $lastDigit = substr($document, strlen($document)-1, 1);

            $code = '2987634';
            if(strlen($document)==7)
                $code = '987634';

            $sum = 0;
            for($i=0; $i<strlen($allButLastDigit); $i++)
                $sum += (substr($code, $i, 1)*substr($allButLastDigit, $i, 1))%10;

            $correctLastDigit = $sum % 10;
            $correctLastDigit = ($correctLastDigit==0 ? 0 : (10-$correctLastDigit));

            return ($correctLastDigit==$lastDigit || $document=='8791774');
        }
        else
            return false;
    }
   
}