<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 14:59
 */

namespace core;


class Session
{
    /**
     * @var \core\Database $db
     */
    protected $db;
    /**
     * @var \core\Request $request
     */
    protected $request;
    protected $raw_session;
    protected $cookies;
    protected $session_time;
    protected $data = [];
    protected $user = [];
    protected $id;

    protected $usertemplate;

    function __construct()
    {
       $this->usertemplate = array(
        "auth"=>false,
        "access"=>0,
        "boss"=>0,
        "document_number"=>0,
        "email"=>'anonymous@oto.com',
        "first_name"=>'anonymous',
        "id"=>-1,
        "issue_date"=>'00-00-00',
        "language"=>[
            'path'=>'russian',
            'name'=>'russian',
            'code'=>'ru',
            'id'=>0
        ],
        "login_crm"=>'',
        "middle_name"=>'anonymous',
        "name"=>'anonymous',
        "photo"=>'images/users/darth-vader.jpg',
        'ip' => $_SERVER['REMOTE_ADDR'],
        'debug'=>'',
        'is_admin'=>false
    );
    }


    public function start(){
        //$this->user = $this->usertemplate;
        $this->request = \YASF::$app->get('Request');
        $this->db = \YASF::$app->get('Database');
        $this->session_time = time();
        if($this->getCookies()){
            $this->raw_session = $this->db->select('session','*',['id'=>$this->cookies['ssid']])[0];
            if(count($this->raw_session)>=1){
                if($this->validate_cookie()){
                    $this->user         = json_decode($this->raw_session['data'],true);
                    $this->data         = json_decode($this->raw_session['session'],true);
                    $this->id           = $this->raw_session['id'];
                    $this->cookies['ssid']      = $this->raw_session['id'];
                    $this->cookies['key']      = $this->raw_session['key'];
                    $this->cookies['token']      = $this->raw_session['token'];
                    $this->pull_user();
                    $this->set_cookie();
                    return $this->id;
                }else{
                    return $this->regenerate_session() ? 0 : -1;
                }

            }
            else
            {
              return $this->regenerate_session() ? 0 : -1;
            }
        }
        else
        {
            return $this->regenerate_session() ? 0 : -1;
        }

    }

    /**
     * @param string $obus = 'yasf' /
     * @return boolean
     */

    public function flush(){
        $insert = [
            'key'           =>   $this->cookies['key'],
            'token'         =>   $this->cookies['token'],
            '(JSON)session' =>   $this->data,
            '(JSON)data'    =>   $this->user,
            'recent_ip'     =>   $this->request->server('REMOTE_ADDR','0.0.0.0'),
        ];
        return $this->db->update('session',$insert,['id'=>$this->cookies['ssid']]) ? true : false;
    }


    //getters & setters;

    /**
     * @return array
     */
    public function getRawSession()
    {
        return $this->raw_session;
    }

   /**
     * Проверка на существоание элемента в сессий
     * @param $key
     * @return bool
     */
    public function hasData($key)
    {
        return isset($this->data[$key]);
    }

    /**
     *удаляет данные сесии, но оставляет доступным пользователя и не уничтожает сессию
     */
    public function destroy_data()
    {
        $this->data = [];
        $this->flush();
    }


    /**
     * Удалить сессию
     * @return bool
     */
    public function destroy() {
        if ($this->validate_cookie()){
            $this->regenerate_session();
            return $this->db->delete('session',['id'=>$this->id]) ? true : false;
        }
        else{
            return false;
        }
    }

    /**
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param array $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value){
        $this->data[$key] = $value;
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default = false){
        return isset($this->data[$key]) ? $this->data[$key]:$default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function user($key = 'auth', $default = false){
        return isset($this->user[$key]) ? $this->user[$key]:$default;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCookie($key){
        return $this->cookies[$key];
    }

    /**
     * @return mixed
     */
    public function getCookieArray(){
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function getUserTemplate()
    {
        return $this->usertemplate;
    }

    // protected

    /**
     * проверяет на валидность сессии
     * @return bool
     */
    protected function validate_cookie(){
        return $this->cookies['ssid']. $this->cookies['key']. $this->cookies['token']== $this->raw_session['id']. $this->raw_session['key']. $this->raw_session['token'] ? true : false;
    }

    /**
     * @return bool
     */
    protected function getCookies()
    {
        if(isset($_COOKIE['ssid']) && isset($_COOKIE['key']) && isset($_COOKIE['token'])){
            $this->cookies = $_COOKIE;
            return true;
        } else{
            return false;
        }

    }

    /**
     *
     */
    protected function pull_user()
    {
        if(!isset($this->user['is_admin'])){
            if(isset($this->user['access']) && $this->user['access']>=999){
                $this->user['is_admin'] = true;
                $this->user['permissions']['menu']['loginto'] = 1;
            }else {
                $this->user['is_admin'] = false;

            }
        }

        if (isset($this->user['access']) && $this->user['access']==999)
        {
            $this->user['template']='/admin/';
        }

        if (!isset($this->user['language'])||$this->user['language']==null)
        {
            $this->user['language']=1;
        }
    }

    /**
     * @param int $time
     * @return bool
     */
    protected function set_cookie($time = DEFAULT_SESSION_LIFE_TIME){
        foreach($this->cookies as $cookie_name => $cookie_value){
            setcookie($cookie_name, $cookie_value, $this->session_time + $time);
        }
        return true;
    }

    protected function regenerate_session($obus = 'yasf')
    {
        $this->cookies['key'] = md5(openssl_random_pseudo_bytes(64, $obus));
        $this->cookies['token'] = md5(openssl_random_pseudo_bytes(8, $obus));

        $insert = [
            'key'           =>   $this->cookies['key'],
            'token'         =>   $this->cookies['token'],
            '(JSON)session' =>   $this->data,
            '(JSON)data'    =>   $this->usertemplate,
            'start_ip'      =>   $this->request->server('REMOTE_ADDR','0.0.0.0'),
            'recent_ip'     =>   $this->request->server('REMOTE_ADDR','0.0.0.0'),
        ];

        $this->cookies['ssid'] = $this->db->insert('session', $insert);



        if($this->cookies['ssid']){
            $this->set_cookie();
            return true;
        }
        else
        {
            return false;
        }

    }




}