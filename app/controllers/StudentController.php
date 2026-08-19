<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
class StudentController extends Controller {
private $valid_student_id = 'MCC2024-00006';
public function index()
{
$this->call->view('student_home');
}
public function confirm()
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$data['error'] = $_SESSION['confirm_error'] ?? null;
unset($_SESSION['confirm_error']);
$this->call->view('student_confirm', $data);
}
public function verify()
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$submitted_id = trim($_POST['student_id'] ?? '');
if ($submitted_id === $this->valid_student_id) {
$_SESSION['student_access'] = true;
redirect('student/profile');
} else {
$_SESSION['confirm_error'] = 'Incorrect Student ID. Please try again.';
redirect('student/confirm');
}
}
public function profile()
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
// Gate: block direct access if the ID was never verified
if (empty($_SESSION['student_access'])) {
$_SESSION['confirm_error'] = 'Please enter your Student ID first.';
redirect('student/confirm');
return;
}
// Consume the access token immediately so the ID must be re-entered next time,
// and so refreshing the profile page doesn't leave it open forever.
unset($_SESSION['student_access']);
$student = [
'student_id' => 'MCC2024-00006',
'name' => 'KC C. Elnas',
'course' => 'BS Information Technology',
'year' => '3rd Year',
'section' => '3-F1',
'email' => 'kccasapao159@gmail.com',
'photo' => 'profile.png', // file inside public/assets/images/
// Left panel content
'hobbies' => ['Eating', 'Sleeping', 'Studying', 'Gaming'],
'skills' => ['Accounting', 'Designing'],
// Right panel content
'socials' => [
['label' => 'Facebook', 'url' => 'https://facebook.com/kc.casapao.elnas#'],
['label' => 'GitHub', 'url' => 'https://github.com/kccasapao159'],
['label' => 'Instagram', 'url' => 'https://instagram.com/kassyhshs/'],
],
];
$this->call->view('student_profile', $student);
}
}