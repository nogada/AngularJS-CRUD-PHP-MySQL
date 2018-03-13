<?php
require_once 'DB.php';
$db = new DB();
$tblName = 'users';
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){
        case "view":
            $records = $db->getRows($tblName);
            if($records){
                //$data['records'] = $db->getRows($tblName, array('where'=>array('id'=>3),'limit'=>'3'));
                $data['records'] = $db->getRows($tblName);
                $data['status'] = 'OK';
            }else{
                $data['records'] = array();
                $data['status'] = 'ERR';
            }
            echo json_encode($data);
            break;
        case "add":
            if(!empty($_POST['data'])){
                $userData = array(
                    'name' => $_POST['data']['name'],
                    'email' => $_POST['data']['email'],
                    'phone' => $_POST['data']['phone']
                );
                $insert = $db->insert($tblName,$userData);
                if($insert){
                    $data['data'] = $insert;
                    $data['status'] = 'OK';
                    $data['msg'] = '고객정보가 등록되었습니다.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = '작업실패, 다시 시도해 주세요.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = '작업실패, 다시 시도해 주세요.';
            }
            echo json_encode($data);
            break;
        case "edit":
            if(!empty($_POST['data'])){
                $userData = array(
                    'name' => $_POST['data']['name'],
                    'email' => $_POST['data']['email'],
                    'phone' => $_POST['data']['phone']
                );
                $condition = array('id' => $_POST['data']['id']);
                $update = $db->update($tblName,$userData,$condition);
                if($update){
                    $data['status'] = 'OK';
                    $data['msg'] = '고객정보가 수정되었습니다.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = '작업실패, 다시 시도해 주세요.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = '작업실패, 다시 시도해 주세요.';
            }
            echo json_encode($data);
            break;
        case "delete":
            if(!empty($_POST['id'])){
                $condition = array('id' => $_POST['id']);
                $delete = $db->delete($tblName,$condition);
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = '고객정보가 삭제되었습니다.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = '작업실패, 다시 시도해 주세요.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = '작업실패, 다시 시도해 주세요.';
            }
            echo json_encode($data);
            break;
        default:
            echo '{"status":"디폴트"}';
    }
}
