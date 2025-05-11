<?php 
//url parsing
function parse_path() {
  $path = array();
  if (isset($_SERVER['REQUEST_URI'])) {
    $request_path = explode('?', $_SERVER['REQUEST_URI']);

    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
    $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      $path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);


    if ($request_path[1]='') {
      $path['query_utf8'] = urldecode($request_path[1]);
       $path['query'] = utf8_decode(urldecode($request_path[1]));
    $vars = explode('&', $path['query']);
    foreach ($vars as $var) {
      $t = explode('=', $var);
      $path['query_vars'][$t[0]] = $t[1];
    }
    }
  
  }
return $path;
}

//first url path
$path = parse_path();
$path_url = $path['call_parts'][1];


//second path
$path_act = (isset($path['call_parts'][2]))?$path['call_parts'][2]:'';
//third path
$path_id = (isset($path['call_parts'][3]))?$path['call_parts'][3]:'';

//fourth path
$path_four = (isset($path['call_parts'][4]))?$path['call_parts'][4]:'';


//fourth five
$path_five = (isset($path['call_parts'][5]))?$path['call_parts'][5]:'';


//simpan role url page user di array sesuai login session level
  $role_user=array();
  $role_act=array();
foreach ($db->query("select sys_menu.url from sys_menu inner join sys_menu_role on sys_menu.id=sys_menu_role.id_menu
    where sys_menu_role.group_id=? and sys_menu_role.read_act=?",array('sys_menu_role.group_id'=>$_SESSION['level'],'sys_menu_role.read_act'=>'Y')) as $role) {
  $role_user[]=$role->url;
}
//lebih detail detil crud role user
foreach ($db->query("select read_act,insert_act,update_act,delete_act from sys_menu inner join sys_menu_role on sys_menu.id=sys_menu_role.id_menu where sys_menu_role.group_id=? and sys_menu.url=?",array('sys_menu_role.group_id'=>$_SESSION['level'],'sys_menu.url'=>$path_url)) as $role) {
  $role_act['up_act']=$role->update_act;
  $role_act['insert_act']=$role->insert_act;
  $role_act['del_act']=$role->delete_act;
}

//obj to array
function toArray($obj)
{
    if (is_object($obj)) $obj = (array)$obj;
    if (is_array($obj)) {
        $new = array();
        foreach ($obj as $key => $val) {
            $new[$key] = toArray($val);
        }
    } else {
        $new = $obj;
    }

    return $new;
}
?>