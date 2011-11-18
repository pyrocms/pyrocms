<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Bước 2: Yêu cầu hệ thống';
$lang['intro_text']		= 	'Bước 2 của quá trình cài đặt kiểm tra máy chủ của bạn có hỗ trợ PyroCMS hay không. Hầu hết các máy chủ đều không gặp phải vấn đề gì khi cài đặt PyroCMS.';
$lang['mandatory']		= 	'Bắt buộc';
$lang['recommended']	= 	'Khuyến cáo';

$lang['server_settings']= 	'Thiết lập HTTP Server';
$lang['server_version']	=	'Máy chủ của bạn:';
$lang['server_fail']	=	'Máy chủ của bạn không được hỗ trợ, do đó PyroCMS có thể hoạt động hoặc không hoạt động. Nếu phiên bản PHP và MySQL của bạn đã được cập nhật thì PyroCMS sẽ hoạt động tốt, tuy nhiên việc tạo URL đẹp có thể không hoạt động.';

$lang['php_settings']	=	'Thiết lập PHP';
$lang['php_required']	=	'PyroCMS yêu cầu PHP phiên bản %s hoặc cao hơn.';
$lang['php_version']	=	'Máy chủ bạn đang chạy phiên bản';
$lang['php_fail']		=	'Phiên bản PHP của bạn không được hỗ trợ. PyroCMS yêu cầu phiên bản PHP %s hoặc cao hơn để có thể hoạt động đúng.';

$lang['mysql_settings']	=	'Thiết lập MySQL';
$lang['mysql_required']	=	'PyroCMS yêu cầu truy cập đến cơ sở dữ liệu MySQL phiên bản 5.0 hoặc cao hơn.';
$lang['mysql_version1']	=	'Máy chủ đang chạy phiên bản';
$lang['mysql_version2']	=	'Máy khách đang chạy phiên bản';
$lang['mysql_fail']		=	'Phiên bản MySQL của bạn không được hỗ trợ. PyroCMS yêu cầu MySQL phiên bản 5.0 hoặc cao hơn để có thể hoạt động đúng.';

$lang['gd_settings']	=	'Thiết lập GD';
$lang['gd_required']	= 	'PyroCMS yêu cầu thư viện GD 1.0 hoặc cao hơn để xử lý hình ảnh.';
$lang['gd_version']		= 	'Máy chủ đang chạy phiên bản';
$lang['gd_fail']		=	'Chúng tôi không thể xác định phiên bản hiện thời của thư viện GD. Thông thường đó là do thư viện GD chưa được cài đặt. PyroCMS sẽ vẫn hoạt động đúng nhưng một vài chức năng xử lý hình ảnh có thể không hoạt động. Chúng tôi khuyến cáo bạn nên kích hoạt thư viện GD.';

$lang['summary']		=	'Tóm tắt';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS yêu cầu Zlib để giải nén và cài đặt themes.';
$lang['zlib_fail']		=	'Không tìm thấy Zlib. Thông thường đó là do Zlib chưa được cài đặt. PyroCMS sẽ vẫn hoạt động đúng nhưng việc cài đặt themes có thể không thực hiện được. Chúng tôi khuyến cáo bạn nên cài đặt thư viện Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS yêu cầu Curl để kết nối đến các website khác.';
$lang['curl_fail']		=	'Không tìm thấy Curl. Thông thường đó là do Curl chưa được cài đặt. PyroCMS sẽ vẫn hoạt động đúng nhưng một vài chức năng có thể không hoạt động. Chúng tôi khuyến cáo bạn nên cài đặt thư viện Curl.';

$lang['summary_success']	=	'Máy chủ của bạn đáp ứng mọi yêu cầu của PyroCMS, Hãy bấm nút dưới đây để tiếp tục cài đặt.';
$lang['summary_partial']	=	'Máy chủ của bạn đáp ứng <em>hầu hết</em> yêu cầu của PyroCMS. PyroCMS sẽ hoạt động tốt, tuy nhiên bạn có thể gặp phải một số vấn đề như co giãn ảnh hay tạo thumbnail.';
$lang['summary_failure']	=	'Máy chủ của bạn khong đáp ứng một số yêu cầu của PyroCMS. Hãy liên hệ nhà cung cấp hoặc quản trị viên để được trợ giúp.';
$lang['next_step']		=	'Bước tiếp theo';
$lang['step3']			=	'Bước 3';
$lang['retry']			=	'Thử lại';

// messages
$lang['step1_failure']	=	'Hãy điền các thiết lập cơ sở dữ liệu được yêu cầu trong biểu mẫu dưới đây..';

/* End of file step_2_lang.php */