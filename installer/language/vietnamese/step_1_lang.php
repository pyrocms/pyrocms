<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Bước 1: Cấu hình cơ sở dữ liệu và máy chủ';
$lang['intro_text']		=	'Cài đặt PyroCMS rất dễ dàng và chỉ mất vài phút. Trong trường hợp không hiểu rõ về các câu hỏi của hệ thống, bạn có thể nhờ sự trợ giúp của nhà cung cấp dịch vụ lưu trữ web hoặc <a href="http://pyrocms.com/contact" target="_blank">liên hệ với chúng tôi</a>.';

$lang['db_settings']	=	'Thiết lập cơ sở dữ liệu';
$lang['db_text']		=	'PyroCMS yêu cầu một cơ sở dư liệu (MySQL) để lưu các thiết lập và nội dung website của bạn, do vậy điều đầu tiên là kiểm tra kết nối đến cơ sở dữ liệu hoạt động tốt. Hãy yêu cầu nhà cung cấp hoặc quản trị viên hỗ trợ trong trường hợp bạn không trả lời được các câu hỏi của hệ thống';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'MySQL Hostname';
$lang['username']		=	'MySQL Username';
$lang['password']		=	'MySQL Password';
$lang['portnr']			=	'MySQL Port';
$lang['server_settings']=	'Thiết lập máy chủ';
$lang['httpserver']		=	'HTTP Server';

$lang['httpserver_text']=	'PyroCMS cần có một HTTP Server để hiển thị nội dung website. Nếu biết chính xác loại HTTP Server, PyroCMS có thể tự cấu hình tốt hơn. Nếu bạn không rõ, có thể bỏ qua và tiếp tục quá trình cài đặt.';
$lang['rewrite_fail']	=	'Bạn đã lựa chọn "(Apache với mod_rewrite)" nhưng chúng tôi không thể xác nhận mod_rewrite đang hoạt động trên máy chủ của bạn. Hãy hỏi nhà cung cấp để xác định mod_rewrite đang hoạt động hoặc tiếp tục quá trình cài đặt nếu bạn có thể tự giải quyết các vẫn đề phát sinh.';
$lang['mod_rewrite']	=	'Bạn đã lựa chọn "(Apache với mod_rewrite)" nhưng máy chủ của bạn chưa kích hoạt module rewrite. Hãy yêu cầu nhà cung cấp kích hoạt hoặc tiếp tục cài đặt sử dụng tùy chọn "Apache (không dùng mod_rewrite)".';
$lang['step2']			=	'Bước 2';

// messages
$lang['db_success']		=	'Cấu hình cơ sở dữ liệu đã đã kiểm tra và hoạt động tốt.';
$lang['db_failure']		=	'Có lỗi khi kết nối đến cơ sở dữ liệu: ';

/* End of file step_1_lang.php */
