<?php

/*
	It is recommended for you to change 'auth_login_incorrect_password' and 'auth_login_username_not_exist' into something vague.
	For example: Username and password do not match.
*/

$lang['auth_login_incorrect_password'] = "パスワードが間違えています";
$lang['auth_login_username_not_exist'] = "ユーザーが存在しません";

$lang['auth_username_or_email_not_exist'] = "ユーザー名もしくはメールアドレスが存在しません";
$lang['auth_not_activated'] = "正式登録されていません。メールをチェックしてみてください。";
$lang['auth_request_sent'] = "既にパスワード変更のメールを送っています。メールをチェックしてみてください。";
$lang['auth_incorrect_old_password'] = "古いパスワードが違っています";
$lang['auth_incorrect_password'] = "パスワードが違います";

// Email subject
$lang['auth_account_subject'] = "%s アカウント詳細";
$lang['auth_activate_subject'] = "%s 登録のご案内";
$lang['auth_forgot_password_subject'] = "パスワード変更のご案内";

// Email content
$lang['auth_account_content'] = "%s から登録のご案内です,

正式登録が完了しました。

以下のサイトよりログインしてください
 %s

今後ともよろしくお願いいたします。

%s より";

$lang['auth_activate_content'] = "%s から登録のご案内です,

%s時間以内に以下のURLをクリックして登録を完了させてください。
%s

メールアドレス: %s

登録した覚えがない場合はこのメールを破棄してください。

%s より";

$lang['auth_forgot_password_content'] = "%s,

パスワード変更申請を受け付けました。以下のURLから変更を完了してください。
%s

新パスワード: %s

変更完了後にパスワードを変更することをおすすめいたします。

何かございましたらお問い合わせください %s.

%s より";

/* End of file dx_auth_lang.php */
/* Location: ./application/language/english/dx_auth_lang.php */