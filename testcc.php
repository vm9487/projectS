<?php
header("Content-type: text/html; charset=utf-8");
/医院
* PDO预处理更新操作
* PDO的预处理使用的是PDOStatement对象
* $pdo->prepare()创建stmt对象
* sql语句中的占位符全部采用：命名占位符，不用？
*/
//1.连接数据库
require 'pdo_connect.php';

//2.sql语句 UPDATE user SET name =:name,email=:email,password=sha1(:password)
$sql="UPDATE `user` SET `user_name`=:user_name,`email`=:email,`password`=sha1(:password) WHERE `user_id`=:user_id";

//3.创建PDO预处理对象stmt
$stmt=$pdo->prepare($sql);

//4.要更新的数据
$data=['user_name'=>'孔明','email'=>'km@qq.com','password'=>'333','user_id'=>1];

/*
 * 4.1绑定变量到预处理对象：SQL语句对象
 * $stmt->bindParam(参数，变量，类型)
 */
//$stmt->bindParam(':name',$data['user_name'],PDO::PARAM_STR);
//$stmt->bindParam(':email',$data['email'],PDO::PARAM_STR);
//$stmt->bindParam(':password',$data['password'],PDO::PARAM_STR);
//5.执行操作
if($stmt->execute($data))
{
    //成功会返回受影响的记录数
    echo '<h3>更新了'.$stmt->rowCount().'条记录</h3>';
}else{
    echo '<h3>更新失败</h3>';
    print_r($stmt->errorInfo());
    die();
}