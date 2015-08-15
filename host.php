<?php
include 'db.php';

class Host
{
    public static function getList($only_active = false)
    {
        static $result;
		//New static variable for keep the last value of $only_active
		static $active;
		
		// Verify if the value of $only_active has change, update the value of $active 
		// and assign to $result empty value.
		if($active !== $only_active ){
			$result = "";
			$active = $only_active;
		}
        
        if (!empty($result)) return $result;
        
		// Change the credential conditional to be able to get all the host with a left join.
        $stmt = "SELECT
                    hos.host_id,
                    hos.host_name,
                    hos.ip_address,
                    cre.username
                 FROM
                    hosts hos 
                    LEFT JOIN credentials cre 
					ON hos.credential_id = cre.credential_id  AND
                    hos.deleted = 0";
        if ($only_active === true) {
            $stmt .= " AND hos.active = 1";
        }
		
        $result = DB::getAll($stmt);
        
        return $result;
    }
}


?>