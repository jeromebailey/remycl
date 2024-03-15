<?php

namespace App\Models\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DatabaseHelper extends Model
{
    use HasFactory;

    public static function generate_row_identifier_for_table( $table_name, $identifier_length=9 ) {

		do {
			$identifier = base64_encode( random_bytes($identifier_length));
		} while (DatabaseHelper::identifier_exist_in_table( $table_name, $identifier) || strstr($identifier, '/') || strstr($identifier, '\/') || strstr($identifier, '+') || strstr($identifier, '//'));

		$identifier = str_replace('/', '', $identifier);
		$identifier = str_replace('+', '', $identifier);
		
		return $identifier;
	}

	public static function identifier_exist_in_table( $table_name, $identifier ) {
		$result = DB::select("select * from " . $table_name . " where row_identifier = '" . addslashes($identifier) ."'");

		//$result = DatabaseHelper::format_query_result_as_array( $query );

		if( empty( $result ) )
			return false;
		return true;
	}

	public static function insert_row_identifier_for_table( $table_name ){
		if( $table_name != null ){
			$table_data = DB::table($table_name)->get();

			if( $table_data != null ){
				foreach( $table_data as $key => $value ){
					//dd($value);
					if( $value->row_identifier == null ){
						$row = DB::table($table_name)
								->where('id', $value->id)
								->update(['row_identifier' => DatabaseHelper::generate_row_identifier_for_table($table_name)]);
					}
					
				}
			}
		}
	}

	/*public static function insert_slug_for_table_model( $model_name, $column_name ){
		if($model_name != null || $model_name != ''){
			$values = Proofofexpenses::all(); //->pluck($column_name);

			foreach ($values as $key => $value) {
				//dd($value->slug);
				if( $value->slug == null ){
					$id = $value->id;
					$column = $value->$column_name;
					$model_object = Proofofexpenses::find($id);
					$model_object->update([
						'slug' => Str::slug($column)
					]);
				}
			}
		}
	}*/

	public static function getTableKeyFromRowIdentifier( $table_name, $row_identifier ){
        $key = 0;
        if($row_identifier !== null || $row_identifier !== ''){
            $key = DB::table($table_name)
							->where('row_identifier',  $row_identifier )
							->get()
							->pluck('id')
							->first();
        }

        return $key;
    }

	public static function getRowIdentifierFromId( $table_name, $id ){
        $key = 0;
        if($id !== null ){
            $row_identifier = DB::table($table_name)
							->where('id',  $id )
							->get()
							->pluck('row_identifier')
							->first();
        }

        return $row_identifier;
    }
}
