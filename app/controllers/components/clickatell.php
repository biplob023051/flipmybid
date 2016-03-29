<?php
class ClickatellComponent extends Object{

    function startup($controller){

    }

    /**
     * Function to send SMS
     */
    function outbound(){

    }

    /**
     * Function to receive SMS
     *
     * Clickatell provides retries of MO callbacks. We follow retry as follows:
     *       1. 2 minutes after the original attempt
     *       2. 4 minutes after last retry
     *       3. 8 minutes after last retry
     *       4. 16 minutes after last retry
     *       5. 25 minutes after last retry (max retries reached)
     *
     * @return array Data of SMS if exist, false otherwise
     */
    function inbound(){
        $data = $_POST ? $_POST : ($_GET ? $_GET : null);
        if(!empty($data)){

            /**
             * Data will consists of:
             *   Api_id (api_id=)
             *   MO message ID (moMsgId)
             *   Originating ISDN (from=)
             *   Destination ISDN (to=)
             *   Date and Time [MySQL format, GMT + 0200] (timestamp=)
             *   DCS Character Coding (charset=) [when applicable]
             *   Header Data [e.g. UDH etc.] (udh=) [when applicable]
             *   Message Data (text=)
             */

            return $data;
        }else{
            return false;
        }
    }
}
?>