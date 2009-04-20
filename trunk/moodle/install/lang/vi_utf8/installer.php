<?php
/// Please, do not edit this file manually! It's auto generated from
/// contents stored in your standard lang pack files:
/// (langconfig.php, install.php, moodle.php, admin.php and error.php)
///
/// If you find some missing string in Moodle installation, please,
/// keep us informed using http://moodle.org/bugs Thanks!
///
/// File generated by cvs://contrib/lang2installer/installer_builder
/// using strings defined in stringnames.txt (same dir)

$string['admindirerror'] = 'Thư mục quản trị được chỉ ra chưa đúng';
$string['admindirname'] = 'Thư mục quản trị';
$string['caution'] = 'Cảnh báo';
$string['closewindow'] = 'Đóng cửa sổ này';
$string['configfilenotwritten'] = 'Kịch bản cài đặt không có khả năng tự động tạo một file config.php file chứa các thiết lập chọn lựa của bạn, có thể thư mục Moodle không có khả năng ghi. Bạn có thể copy bằng tay đoạn mã sau vào một file đặt tên là config.php trong thư mục gốc của Moodle.';
$string['configfilewritten'] = 'config.php được tạo một cách thành công';
$string['continue'] = 'Tiếp tục';
$string['database'] = 'Cơ sở dữ liệu';
$string['dataroot'] = 'Thư mục dữ liệu';
$string['datarooterror'] = ' \'Thư mục dữ liệu\' bạn chỉ ra không thể được tìm thấy hoặc được tạo. Hoặc đường dẫn đúng hoặc tạo thư mục   Either correct the path or create that directory manually.';
$string['dbconnectionerror'] = 'Chúng tôi không thể kết nối cơ sở dữ liệu bạn chỉ ra. Vui lòng kiểm tra các thiết lập cơ sở dữ liệu.';
$string['dbcreationerror'] = 'Lỗi tạo cơ sở dữ liệu. Không thể tạo tên cơ sở dữ liệu với các thiết lập được cung cấp';
$string['dbhost'] = 'Host Server';
$string['dbprefix'] = 'Các bảng cố định trước';
$string['dbtype'] = 'Type';
$string['dirroot'] = 'Thư mục Moodle';
$string['dirrooterror'] = '  Thiết lập \'Thư mục Moodle\' dường như không đúng - chúng tôi không thể tìm thấy các file cài đặt Moodle ở đó. Giá trị dưới đây được đặt lại.';
$string['download'] = 'Tải xuống';
$string['environmentrequireinstall'] = 'cầnphải được cài hay kích hoạt.';
$string['error'] = 'Lỗi';
$string['fail'] = 'Thất bại';
$string['fileuploads'] = 'File tải lên';
$string['fileuploadserror'] = 'Điều này sẽ là';
$string['fileuploadshelp'] = '<p>File tải lên dường như bị vô hiệu hoá trên máy chủ của bạn.</p>

<p>Moodle vẫn có thể được cài đặt, nhưng không có khả năng này, bạn sẽ không có khả 
   năng tải lên các tài liệu cua học hoặc các ảnh trong hồ sơ người dùng.</p>

<p>Để có thể tải file lên (hoặc nhà quản trị hệ thống của bạn ) sẽ cần 
   soạn thảo file php.ini trên hệ thống của bạn và thay đổi thiết lập đối với 
   <b>file tải lên</b> thành \'1\'.</p>';
$string['gdversion'] = 'Phiên bản GD';
$string['gdversionerror'] = 'Thư viện GD nên được cho phép để xử lý và tạo các hình ảnh';
$string['gdversionhelp'] = '<p> Máy chủ của bạn hình như không cài GD.</p>

<p>GD là một thư viện mà được yêu cầu bởi PHP để cho phép Moodle xử lý các hình ảnh 
   (như biểu tượng trong hồ sơ các nhân) và tạo các hình ảnh mới (ví dụ 
   các đồ thị bản ghi).  Moodle vẫn làm việc không có GD - những đặc trưng này sẽ 
   không có sẵn đối với bạn.</p>

<p>Để thêm GD vào PHP dưới hệ điều hành Unix, biên dịch PHP sử dụng tham số--with-gd. </p>

<p>Dưới hệ điều hành Windows bạn có thể soạn thảo file php.ini và bỏ dấu chú thích dòng tham chiếu đến php_gd2.dll.</p>';
$string['help'] = 'Trợ giúp';
$string['installation'] = 'Cài đặt';
$string['language'] = 'Ngôn ngữ';
$string['magicquotesruntime'] = 'Magic Quotes Run Time';
$string['magicquotesruntimeerror'] = 'Điều này nên là off';
$string['magicquotesruntimehelp'] = '<p>Magic quotes runtime nên được tắt để Moodle hoạt động đúng.</p>

<p>Bình thường theo mặc định nó là off...nhìn thiết lập <b>magic_quotes_runtime</b> trong file php.ini của bạn.</p>

<p>Nếu bạn không thể truy cập file php.ini của bạn, bạn có thể đặt dòng sau trong một file  
   gọi là .htaccess trong thư mục Moodle của bạn:
   <blockquote>php_value magic_quotes_runtime Off</blockquote>
</p>   
   ';
$string['memorylimit'] = 'Giới hạn bộ nhớ';
$string['memorylimiterror'] = 'PHP thiết lập giới hạn bộ nhớ quá thấp... you may run into problems later.';
$string['memorylimithelp'] = '<p> PHP thiết lập giới hạn bộ nhớ cho máy chủ của bạn hiện tại là $a.</p>

<p>Đây có thể là nguyên nhân Moodle có các vấn đề về bộ nhớ vào một thời điểm nào đó, đặc biệt 
   nếu bạn có nhiều môđun được cho phép và nhiều người dùng.

<p>Chúng tôi đề nghị rằng bạn cấu hình PHP với một giới hạn lớn hơn nếu có thể, chẳng hạn như 40M.  
   Có một số cách để làm điều này mà bạn có thể thử:
<ol>
<li>Nếu bạn có khả năng, biên tập lại PHP với <i>--giới hạn bộ nhớ cho phép</i>.  
	Điều này sẽ cho phép Moodle tự thiết lập giới hạn bộ nhớ.
<li>Nếu bạn truy cập file php.ini của bạn, bạn có thể thay đổi <b>giới hạn bộ nhớ</b> 
	thiết lập trong đó thành một giá trị nào đó chẳng hạn như 40M. Nếu bạn không được phép truy cập 
	bạn có thể yêu cầu quản trị viên của bạn để làm điều đó cho bạn.</li>
<li> Trên một số máy chủ chạy PHP bạn có thể tạo một file .htaccess trong thư mục Moodle  
	chứa dòng này:
	<p><blockquote> giá trị giới hạn bộ nhớ 40M</blockquote></p>
	<p>Tuy nhiên, trên một số máy chủ điều này có thể ngăn cản <b>tất cả</b> các trang PHP làm việc 
	(bạn sẽ nhìn thấy các lỗi khi bạn xem xét những trang này )vì thế bạn sẽ pahỉ di chuyền file .htaccess.</p></li>
</ol>';
$string['moodledocslink'] = 'Tài liệu cho trang này';
$string['mysqlextensionisnotpresentinphp'] = 'PHP chưa được cấu hình thuộc tính với đuôi mở rộng MySQL với mục đích là để nó có thể làm việc tốt với MySQL. Vui lòng kiểm tra file php.ini hoặc biên dịch lại PHP.';
$string['name'] = 'Tiêu đề';
$string['next'] = 'Tiếp theo';
$string['ok'] = 'Đồng ý';
$string['pass'] = 'Pass';
$string['password'] = 'Mật khẩu';
$string['phpversion'] = 'Phiên bản PHP';
$string['phpversionerror'] = 'Phiên bản PHP phải ít nhất là 4.1.0';
$string['phpversionhelp'] = '<p>Moodle yêu cầu một phiên bản PHP ít nhất là 4.1.0.</p>
<p>Bạn đang dùng phiên bản hiện hành $a</p>
<p>Ban phải nâng cấp PHP hoặc di chuyển một máy chủ với một phiên bản PHP mới hơn!</p>';
$string['previous'] = 'Trước';
$string['safemode'] = 'Chế độ an toàn ';
$string['safemodeerror'] = 'Moodle có thể gặp một số sự cố với chế độ an toàn';
$string['safemodehelp'] = '<p>Moodle có thể có một số vấn đề với chế độ an toàn, 
	đặc biệt là nếu nó không được phép tạo các file mới.</p>
   
<p>Chế độ an toàn thường được các host web bật lên, do đó bạn có thể
   phải tìm cung cấp một công ty host web mới cho site Moodle của bạn.</p>
   
<p>Bạn có thể thử tiếp tục cài đặt nếu bạn thích, nhưng có thể phát sinh một số vấn đề sau này.</p>';
$string['sessionautostart'] = 'Bắt đầu tự động Session ';
$string['sessionautostarterror'] = 'Điều này nên là tắt';
$string['sessionautostarthelp'] = '<p>Moodle yêu cầu hỗ trợ session và sẽ không làm việc nếu không có nó.</p>

<p>Sessions có thể được cho phép trong file php.ini ... tìm kiếm tham số session.auto_start.</p>';
$string['status'] = 'Trạng thái';
$string['thischarset'] = 'UTF-8';
$string['thisdirection'] = 'ltr';
$string['thislanguage'] = 'Vietnamese';
$string['user'] = 'Người dùng';
$string['wwwroot'] = 'Địa chỉ web';
$string['wwwrooterror'] = ' Địa chỉ web không hợp lệ - Các file cài đặt Moodle không xuất hiện ở đó.';
?>