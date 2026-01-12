<?php
class JConfig {

	//CONFIG GENERALE
	public $filelocation = 'LEPBI';
	public $sitename = 'Lepbi.fr';
	public $offline = '0';
	public $offline_message = 'This site is down for maintenance.<br />Please check back again soon.';
	public $display_offline_message = '2';
	public $offline_image = '';
	public $editor = 'tinymce';
	public $secret = 'jf6otUUQAQOUAxfw';
	public $sharingkey = 'QHXYzA2fQhmtoilrvWSa';

	//BDD VITRINE
	public $dbtype = 'mysqli';
	public $host = 'localhost';
	public $user = 'phpmyadmin';
	//public $password = 'BDDRoot66!';
	public $password = '';
	public $db = 'vitrine';
	public $dbprefix = 'jwrib6_';

	//INFOS BACK
	public $urlBack = 'http://localhost/';
	public $remotetoken = 'http://localhost';
	//public $GBMNet_dbprefix = 'mod643_';
	public $GBMNet_dbprefix = '';
	public $GBMNet_db = 'cceapic_251125';
	// public $GBMNet_password = '6gUf25kqUKna';
	public $GBMNet_password = '';
	public $GBMNet_user = 'root';
	public $GBMNet_host = 'localhost';
	public $GBMNet_dbtype = 'mysqli';

	//CONFIG AFFICHAGE ERREUR
	public $error_reporting = 'maximum';
	//public $error_reporting = 'simple';
	//public $error_reporting = 'none';

	//CONFIG A TRIER
	public $captcha = '0';
	public $list_limit = '20';
	public $access = '1';
	public $debug = '0';
	public $debug_lang = '0';
	public $debug_lang_const = '1';
	public $live_site = '';
	public $gzip = '0';

	public $helpurl = 'https://help.joomla.org/proxy?keyref=Help{major}{minor}:{keyref}&lang={langcode}';
	public $ftp_host = '';
	public $ftp_port = '';
	public $ftp_user = '';
	public $ftp_pass = '';
	public $ftp_root = '';
	public $ftp_enable = '0';
	public $offset = 'UTC';
	public $mailonline = '1';
	public $mailer = 'mail';
	public $mailfrom = 'tayebmimouni@lepbi.com';
	public $fromname = 'Joomla';
	public $sendmail = '/usr/sbin/sendmail';
	public $smtpauth = '0';
	public $smtpuser = '';
	public $smtppass = '';
	public $smtphost = 'localhost';
	public $smtpsecure = 'none';
	public $smtpport = '25';
	public $caching = '0';
	public $cache_handler = 'file';
	public $cachetime = '15';
	public $cache_platformprefix = '0';
	public $MetaDesc = 'Site lepbi.fr';
	public $MetaKeys = '';
	public $MetaTitle = '1';
	public $MetaAuthor = '1';
	public $MetaVersion = '0';
	public $robots = '';
	public $sef = '1';
	public $sef_rewrite = '0';
	public $sef_suffix = '0';
	public $unicodeslugs = '0';
	public $feed_limit = '10';
	public $feed_email = 'none';
	public $log_path = '/var//www/html/joomla/logs';
	public $tmp_path = '/var/www/html/joomla/tmp';
	public $lifetime = '360';
	public $session_handler = 'none';
	public $shared_session = '0';
	public $memcache_persist = '1';
	public $memcache_compress = '0';
	public $memcache_server_host = 'localhost';
	public $memcache_server_port = '11211';
	public $memcached_persist = '1';
	public $memcached_compress = '0';
	public $memcached_server_host = 'localhost';
	public $memcached_server_port = '11211';
	public $redis_persist = '1';
	public $redis_server_host = 'localhost';
	public $redis_server_port = '6379';
	public $redis_server_db = '0';
	public $proxy_enable = '0';
	public $proxy_host = '';
	public $proxy_port = '';
	public $proxy_user = '';
	public $massmailoff = '0';
	public $replyto = '';
	public $replytoname = '';
	public $MetaRights = '';
	public $sitename_pagetitles = '0';
	public $force_ssl = '0';
	public $session_memcache_server_host = 'localhost';
	public $session_memcache_server_port = '11211';
	public $session_memcached_server_host = 'localhost';
	public $session_memcached_server_port = '11211';
	public $session_redis_persist = '1';
	public $session_redis_server_host = 'localhost';
	public $session_redis_server_port = '6379';
	public $session_redis_server_db = '0';
	public $frontediting = '1';
	public $cookie_domain = '';
	public $cookie_path = '';
	public $asset_id = '1';
	public $behind_loadbalancer = '0';
}
