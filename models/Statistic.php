<?php
namespace app\models;

use app\models\tables\Users;
use app\models\tables\UsersOnline;

class Statistic
{

    /**
     * @return array
     */
    public function getUsersOnline() : array
    {
        $result = UsersOnline::find()->asArray()->all();

		$allUsers = Users::find()->asArray()->all();

        foreach ( $result as &$user )
        {
            $userID = $user['user_id'];
            foreach ( $allUsers as $u )
            {
                if ( $userID == $u['id'] )
                    $user['fio'] = $u['fio'];
            }
        }

		return $result;
	}

    /**
     * Insert new user in table or update if already exist
     */
	public function setUserOnline()
    {
        //$sess_path = session_save_path();
        $rUo = UsersOnline::find()->asArray()->all();

        $device = $this->getUserOSData();//$_SERVER['HTTP_SEC_CH_UA_PLATFORM']??'';

        foreach ( $rUo as $userO )
        {
            if ( $userO['session_id'] === session_id() )
            {
                // found this user. renew
                $upd = UsersOnline::find()
                    ->select(['id','device','views_count','update_connect'])
                    ->where(['=','session_id',session_id()])
                    ->one();

                $upd->device = $device;
                $upd->views_count = ++$userO['views_count'];
                $upd->update_connect = date('Y-m-d H:i:s');

                $upd->save(false);
                return;
            }
        }

        // add new user in table
        $new = new UsersOnline();
        $new->session_id = session_id();
        $new->user_ip = $_SERVER['REMOTE_ADDR'];
        $new->device = $device;
        $new->views_count = 1;
        $new->first_connect = date('Y-m-d H:i:s');
        $new->update_connect = date('Y-m-d H:i:s');

        $new->save(false);
    }

    public function getUserOSData() : string
    {
        $countryCode = $_SERVER['HTTP_GEOIP_COUNTRY_CODE']??"";
        $ua = $_SERVER['HTTP_USER_AGENT']??" ";

        $ua_arr = explode(' ', $ua);
        $userBrowser = $ua_arr[count($ua_arr)-1];

        $posStart = stripos($ua, '(');
        $posEnd = stripos($ua, ')');
        $userMachine = substr($ua,$posStart,++$posEnd-$posStart);

        return $countryCode . " " .$userMachine . " " . $userBrowser;
    }

    /**
     * Will remove users from online when their update_connect more then 1 hour pass
     * @throws \yii\db\StaleObjectException
     */
    public function removeExpiredUsers()
    {
        $rUo = UsersOnline::find()->asArray()->all();

        $currentTime = time();

        foreach ( $rUo as $userO )
        {
            $lastTime = strtotime($userO['update_connect'] . " +1 day");
            if ( $lastTime < $currentTime )
            {
                UsersOnline::findOne($userO['id'])->delete();
            }
        }
    }

}