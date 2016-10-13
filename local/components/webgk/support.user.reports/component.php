<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


    //Include module
    Cmodule::IncludeModule("webgk.support");


    //check user group
    global $USER;
    $user_id = $USER->GetID();    
    $staff_group_id = GKSupport::GetSupportEmployerGroupID();
    $user_groups = CUser::GetUserGroupArray();

    //if user not in support staff group
    if (!in_array($staff_group_id, $user_groups)) {
        return false; 
    }

    //add reports
    if ($_POST["submit-reports"] 
        && is_array($_POST["work-report"]) && count($_POST["work-report"]) > 0
        && is_array($_POST["work-report-time"]) && count($_POST["work-report-time"]) > 0
    ) {
        foreach ($_POST["work-report"] as $date => $report) {
            //add report
            if (!empty($report)) {
                $report_data = array("EMPLOYE_ID" => $user_id, "TIME" => $_POST["work-report-time"][$date], "DATE" => $date, "TEXT" => $report); 
                $work_report = new GKSupportReports;       
                $work_report->Add($report_data);
            }
        }

        global $APPLICATION;
        LocalRedirect($APPLICATION->GetCurPage());
    }      


    /**
    * check user reports
    * 
    * @param integer $ID - user ID
    */
    function checkUserReposts($ID) {

        $ID = intval($ID);          
        if (empty($ID) || $ID < 0) {
            return false;
        }

        //get days count for request
        $current_day = date("w");
        if ($current_day == 1) {  //monday
            $day_count = 7; 
        } else if ($current_day != 0 && $current_day != 6) { //not sunday and saturday
            $day_count = $current_day - 1;
        }

        //array of dates to check work time
        $dates_to_check = array();

        $auth_history = CEventLog::GetList(
            Array("ID" => "DESC"), 
            array(
                "USER_ID" => $ID, 
                "AUDIT_TYPE_ID" => "USER_AUTHORIZE", 
                'TIMESTAMP_X_1' => date("d.m.Y 00:00:00", date("U") - 86400 * $day_count), 
                'TIMESTAMP_X_2' => date("d.m.Y 23:59:59", date("U") - 86400)
            )
        );

        while($arAuthHistory = $auth_history->Fetch()) {
            $date = substr($arAuthHistory["TIMESTAMP_X"], 0, 10);
            $dates_to_check[] = $date;
        }
        $dates_to_check = array_unique($dates_to_check);

        //check days where user was authorized in support
        if (count($dates_to_check) > 0) {
            $user_norm = GKSupportNorms::GetUserNorm($ID);      


            //if user has no norm of norm = 0
            if ($user_norm <= 0) {
                return false;
            }       

            //array of dates without reports
            $dates_without_reports = array();
            $dates_without_reports["USER_NORM"] = $user_norm;

            //check reports for dates
            foreach ($dates_to_check as $date) {  

                $requestDate = ConvertDateTime($date, "YYYY-MM-DD");

                //check work time minutes
                $spent_time = 0;
                $hours = 0;
                $minutes = 0;
                $full_time = "";
                $rsSpentTime = GKSupportSpentTime::GetList($by = "ID", $sort = "ASC", array(">=DATE" => $requestDate." 00:00:00", "<=DATE" => $requestDate." 23:59:59", "USER_ID" => $ID));
                while($arSpentTime = $rsSpentTime->Fetch()) {
                    $hours += $arSpentTime["HOURS"];
                    $minutes += $arSpentTime["MINUTES"];
                    $spent_time += $arSpentTime["HOURS"] * 60 + $arSpentTime["MINUTES"];
                }

                $full_time = $hours + intval($minutes / 60) . ":" . $minutes % 60;

                //get minutes from hours
                $spent_time = round($spent_time / 60, 1);                   

                //if work time in this day less then user work norm
                if ($spent_time < $user_norm) {    
                    //check report
                    $report = new GKSupportReports;                      
                    $rsReport = $report->GetList($by="ID", $sort="ASC", $arFilter = array("DATE" => $requestDate, "EMPLOYE_ID" => $ID));
                    $arReport = $rsReport->Fetch();

                    //if date has no report
                    if (empty($arReport)) {
                        $dates_without_reports["DATES"][] = array("DATE" => $date, "TIME" => $full_time); 
                    }
                }
            }

            if (!empty($dates_without_reports)) {
                return $dates_without_reports;
            } else {
                return false;
            }
        }  

        else {
            return false;
        }
    }

    $dates = checkUserReposts($user_id);      

    $arResult["DATES"] = $dates["DATES"];    
    //format user norm
    $arResult["USER_NORM"] = intval($dates["USER_NORM"]). ":" .($dates["USER_NORM"] * 60) % 60;     

    $this->IncludeComponentTemplate();
?>