<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionHelper extends Model
{
    use HasFactory;

    public static function addRequiredDocument($document_type_name){
        if( session()->has('required_documents') ){
            $required_documents[] = session('required_documents');
            $count = count($required_documents);
            $required_documents[$count+1] = $document_type_name;
            session(['required_documents' => $required_documents]);
        } else {
            SessionHelper::addDefaultRequiredDocumentsToSession();
        }
    }

    public static function addDefaultRequiredDocumentsToSession(){
        $required_documents = array(
            'photo_identification',
            'proof_of_citizenship'
        );
        session(['required_documents' => $required_documents]);
    }
}
