<?PHP
//
// ZendTo
// Copyright (C) 2006 Jeffrey Frey, frey at udel dot edu
// Copyright (C) 2011 Julian Field, Jules at ZendTo dot com 
//
// Based on the original PERL dropbox written by Doke Scott.
// Developed by Julian Field.
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
//

//
// This file contains all the non-user interface parts of the ZendTo
// configuration.
// Before editing this file, read
//     http://zend.to/preferences.php
// as it will tell you what everything does, and lists all the settings
// you *must* change for it to work on your site.
// After that, look for the strings "soton" and "ECS" to be sure you
// don't miss anything.
//

define('NSSDROPBOX_BASE_DIR','/opt/zendto/');
define('NSSDROPBOX_LIB_DIR','/opt/zendto/lib/');
define('NSSDROPBOX_DATA_DIR','/var/zendto/');

// This defines the version number, please do not change
define('ZTVERSION','4.12');

// Is this ZendTo or MyZendTo?
define('MYZENDTO','FALSE');

// This is for gathering nightly stats, see docs about RRD and root's crontab
define('RRD_DATA_DIR',NSSDROPBOX_DATA_DIR.'rrd/');
define('RRD_DATA',RRD_DATA_DIR.'zendto.rrd');
define('RRDTOOL','/usr/bin/rrdtool');

// This sets which Database engine you are using, either 'SQLite' or 'SQLite3'
// or 'MySQL'. If you are using SQLite on Ubuntu 12 (and higher) servers, be
// sure to specify 'SQLite3' and not 'SQLite'.
// It must look like one of these 3 examples:
// define('SqlBackend', 'SQLite');
// define('SqlBackend', 'SQLite3');
// define('SqlBackend', 'MySQL');
define('SqlBackend', 'MySQL');

//
// Preferences are stored as a hashed array.  Inline comments
// indicate what everything is for.
//
$NSSDROPBOX_PREFS = array(

  // Next line needed for SQLite operation
  'SQLiteDatabase'       => NSSDROPBOX_DATA_DIR."zendto.sqlite",

  // Next 4 lines needed for MySQL operation
  'MySQLhost'            => 'db',
  'MySQLuser'            => 'zendto',
  'MySQLpassword'        => 'zendto',
  'MySQLdb'              => 'zendto',

  // These describe the ZendTo and where a few things live
  'dropboxDirectory'     => NSSDROPBOX_DATA_DIR."dropoffs",
  'logFilePath'          => NSSDROPBOX_DATA_DIR."zendto.log",
  'numberOfDaysToRetain' => 14,
  'showRecipsOnPickup'   => TRUE,
  // You cannot increase these 2 numbers on 32-bit platforms.
  'maxBytesForDropoff'   => 2147483647, // 2 GBytes - 1 = 2^32-1
  'maxBytesForFile'      => 2147483647, // 2 GBytes - 1 = 2^32-1
  // If your MaxBytesForFile or MaxBytesForDropoff are 4 GBytes or more,
  // then set this to FALSE as Windows cannot work the upload progress bar
  // for files of 4 GBytes or more (except IE 64-bit on Windows 7 64-bit)..
  // Setting this to FALSE always works, but does not give actual upload
  // progress indication, just an animated picture to show it hasn't crashed.
  'useRealProgressBar'   => TRUE,

  // If you send someone a request for a Drop-off, how long do they have
  // in which to reply?
  'requestTTL'           => 86400, // 1 day
  // When files are submitted in response to a request, you might want to
  // over-ride the recipient's email address to force the "files have been
  // dropped off for you" emails to go into your ticketing system's email
  // engine for automatic ticket assignment, rather than being sent to the
  // customer support rep who sent the request
  'requestTo'            => '', // Set to '' to disable this override

  // Maximum length of a submitted Request Subject, and Short Note
  'maxSubjectLength'     => 100,
  'maxNoteLength'        => 1000,

  // This lists all the network numbers (class A, B and/or C) which your
  // site uses. Users coming from here will be considered "local" which
  // can be used to affect the user interface they get. If they visit ZendTo
  // from a "local" IP address, they are strongly encouraged to login
  // before trying to drop off files or use ZendTo.
  // Replace the contents of this array with a list of the network prefixes
  // you use for your site.
  'localIPSubnets'       => array(),

  // Do you want to restrict downloads to humans only? If this is false,
  // you may get a Denial of Service attack as anyone with the URL to
  // reach a file can download it, even malicious people. So someone can
  // command a botnet to download the same file 1,000,000 million times
  // simultaneously. Bad news for your server!
  // If this is true, unauthorised users trying to download a file have
  // to prove they are a real person and not a program.
  'humanDownloads' => true,

  // When a user sends a new drop-off, do you want the sender to also
  // receive a copy of the email sent to the recipients? It will be a
  // Bcc copy of the message sent to the 1st recipient.
  'bccSender' => FALSE,

  // If you want to be able to optionally send files from a "library"
  // directory of frequently used files, set this to TRUE.
  // This will enable a user to either upload a file or pick one from
  // the library. The description used with the libary file will be whatever
  // the last user set it to for that library file.
  'usingLibrary' => FALSE,

  // This is the location of the library directory referred to above.
  // You might want to set up a WebDAV directory in your Apache web
  // server configuration, so that administrators can easily manage the
  // files in the library. Default points to /var/zendto/library.
  // The library should contain the files you want users to see in the
  // "new dropoff" form.
  // If you create subdirectories in here named the same as a username,
  // that user will see just the files in their subdirectory instead;
  // over-riding the files in the libraryDirectory itself.
  // If there are no files present, the library drop-down will not be
  // shown in the web user interface.
  // So by leaving libraryDirectory itself empty, but putting files in a
  // user's subdirectory, you can create a setup where only that user will
  // see any sign of there being a library.
  'libraryDirectory' => NSSDROPBOX_DATA_DIR."library",

  // This has only affects users of MyZendTo (very few people).
  // When using MyZendTo, there is a default value for the storage quota
  // each user has. This means you only have to add users with bin/adduser.php
  // and maintain their quota with bin/setquota.php when the default quota
  // is not right for them. This saves an awful lot of administrative work,
  // as you do not have to match your local user table in MySQL/SQLite with
  // all the users that can authenticate with AD/IMAP/LDAP and so on.
  // Value in bytes.
  'defaultMyZendToQuota' => 100000000, // 100 Mbytes

  // There are 2 CAPTCHAs available:
  // 1. The much improved Google reCAPTCHA v2, OR
  // 2. The AreYouAHuman CAPTCHA,
  // OR you can choose to disable the CAPTCHA altogether. If you do this
  //    it will be possible for bad people to attack your ZendTo website
  //    and send anyone in your organisation any malicious file they like.
  // The setting below must be one of 'google', 'areyouahuman' or 'disabled'.
  'captcha' => 'disabled',

  // Settings for the Google reCAPTCHA
  //
  // Get these 2 values from
  // https://www.google.com/recaptcha/admin
  'recaptchaPublicKey'   => '-Google-reCAPTCHA-Site-Key-Goes-Here---',
  'recaptchaPrivateKey'  => '-Google-reCAPTCHA-Secret-Key-Goes-Here-',
  // Do you need to use a proxy to reach the recaptcha server at Google?
  // If so, put their hostname/IP and port number in here.
  'recaptchaProxyHost'   => '',
  'recaptchaProxyPort'   => '',

  // Settings for the AreYouAHuman CAPTCHA
  //
  // Get these 2 values from http://portal.areyouahuman.com/login/
  // Note: In that portal, you must set the "Game Style" to "Embedded".
  'ayah_publisher_key'   => '--AreYouAHuman-Publisher-Key-Goes-Here--',
  'ayah_scoring_key'     => '---AreYouAHuman-Scoring-Key-Goes-Here---',

  // These are the usernames of the ZendTo administrators at your site.
  // Regardless of how you login, these must be all lower-case.
  'authAdmins'           => array('admin'),

  // These usernames can only view the stats graphs, they cannot do other
  // admin functions. They can up and down load drop-offs, of course.
  // Regardless of how you login, these must be all lower-case.
  'authStats'            => array('view1','view2','view3'),

  //
  // Settings for the Local SQL-based authenticator.
  //
  // See the commands in /opt/zendto/bin and the ChangeLog to use this.
  'authenticator' => 'Local',

  //
  // Settings for the IMAP authenticator.
  //
  // If you work in a multi-domain site, where users authenticate by
  // entering their entire email address rather than just their username,
  // simply set 'authIMAPDomain' => '' and it will treat their full
  // email address as their username and then work as expected.
  //
  // To change the port add ":993" to the server name, to use SSL add "/ssl".
  // for other changes see flags for PHP function "imap_open" on php.net.
  // For example, recent versions of PHP try to use TLS where possible, so
  // if you are connecting to localhost then add "/novalidate-cert" on to the
  // end of your server name.
  // 'authenticator' => 'IMAP',
  'authIMAPServer' => 'mail.soton.ac.uk',
  'authIMAPDomain' => 'soton.ac.uk',
  'authIMAPOrganization' => 'University of Southampton',
  'authIMAPAdmins' => array(),

  //
  // Settings for the LDAP authenticator.
  //
  // 'authenticator'         => 'LDAP',
  // 'authLDAPBaseDN'        => 'OU=users,DC=soton,DC=ac,DC=uk',
  // 'authLDAPServers'       => array('ldap1.soton.ac.uk','ldap2.soton.ac.uk'),
  // 'authLDAPAccountSuffix' => '@soton.ac.uk',
  // 'authLDAPUseSSL'        => false,
  // 'authLDAPBindDn'        => 'o=MyOrganization,uid=MyUser',
  // 'authLDAPBindPass'      => 'SecretPassword',
  // 'authLDAPOrganization'  => 'My Organization',
  // This is the list of LDAP properties used to build the user's full name
  // 'authLDAPFullName'      => 'givenName sn',
  // If both these 2 settings are set, then the users must be members of this
  // group/role.
  // 'authLDAPMemberKey'     => 'memberOf',
  // 'authLDAPMemberRole'    => 'cn=zendtoUsers,OU=securityGroups,DC=soton,DC=ac,DC=uk',

  //
  // Settings for the 2-forest/2-domain AD authenticator.
  // Set 
  //     'authLDAPServers2' => array(),
  // if you only have to search 1 AD forest/domain.
  //
  // If you want to search for your user in multiple OUs in either or both
  // of the forests/domains, then make the authLDAPBaseDN1 (or 2) an array
  // of OUs, such as in this example:
  // 'authLDAPBaseDN1' => array('OU=Staff,DC=mycompany,DC=com',
  //                            'OU=Interns,DC=mycompany,DC=com'),
  // Of course the same works for 'authLDAPBaseDN2'.
  //
  // 'authenticator'             => 'AD',
  'authLDAPBaseDN1'           => 'OU=users,DC=ecs,DC=soton,DC=ac,DC=uk',
  'authLDAPServers1'          => array('ad1.ecs.soton.ac.uk','ad2.ecs.soton.ac.uk'),
  'authLDAPAccountSuffix1'    => '@ecs.soton.ac.uk',
  'authLDAPUseSSL1'           => false,
  'authLDAPBindUser1'         => 'SecretUsername1',
  'authLDAPBindPass1'         => 'SecretPassword1',
  'authLDAPOrganization1'     => 'ECS, University of Southampton',
  // If you are not using this 2nd set of settings for a 2nd AD forest,
  // do not comment them out, but instead set them to be empty.
  'authLDAPBaseDN2'           => 'DC=soton,DC=ac,DC=uk',
  // Set 
  //     'authLDAPServers2' => array(),
  // if you only have to search 1 AD forest/domain.
  'authLDAPServers2'          => array('ad1.soton.ac.uk','ad2.soton.ac.uk'),
  'authLDAPAccountSuffix2'    => '@soton.ac.uk',
  'authLDAPUseSSL2'           => false,
  'authLDAPBindUser2'         => 'SecretUsername2',
  'authLDAPBindPass2'         => 'SecretPassword2',
  'authLDAPOrganization2'     => 'University of Southampton',

  // If both these 2 settings are set, then the users must be members of this
  // group/role. Please note this feature has not been rigorously tested yet.
  // 'authLDAPMemberKey'     => 'memberOf',
  // 'authLDAPMemberRole'    => 'cn=zendtoUsers,OU=securityGroups,DC=soton,DC=ac,DC=uk',

  // the default email domain when just usernames are supplied
  'defaultEmailDomain' => 'example.com',

  // You need to change this setting!
  //
  // This should either be a regular expression or a filename.
  // It defines the domain(s) that un-authenticated users can send
  // files to. Authenticated users can send to everywhere.
  //
  // * Filename *
  // If it is a filename, it must start with a / and not end with one.
  // The file will contain a list of domain names, one per line.
  // Blank lines and comment lines starting wth '#' will be ignored.
  // If a line contains "domain.com" for example, then the list of
  // recipient email domains for un-authenticated users will contain
  // "domain.com" and "*.domain.com".
  //
  // * Regular Expression *
  // This defines the recipient email domain(s) for un-authenticated users.
  // This example matches "soton.ac.uk" and "*.soton.ac.uk".
  // 'emailDomainRegexp' => '/^([a-zA-Z\.\-]+\.)?soton\.ac\.uk$/i',
  //
  // 'emailDomainRegexp' => '/opt/zendto/config/internaldomains.txt',
  'emailDomainRegexp' => '/^([a-zA-Z\.\-]+\.)?soton\.ac\.uk$/i',

  // Regular expression defining a valid username for the Login page.
  // Usually no need to change this.
  'usernameRegexp'    => '/^([a-zA-Z0-9][a-zA-Z0-9\_\.\-\@\\\]*)$/i',

  // regular expression defining a valid email address for anyone.
  // Must look like /^(user)\@(domain)$/
  'validEmailRegexp' => '/^([a-zA-Z0-9][a-zA-Z0-9\.\_\-\+\&\']*)\@([a-zA-Z0-9][a-zA-Z0-9\_\-\.]+)$/i',

  // If a user fails to login with the correct password 'loginFailMax' times
  // in a row within 'loginFailTime' seconds, then the user is locked out
  // until the time period has passed.  86400 seconds = 1 day.
  // That means that if you fail to log in successfully 6 times in a row in
  // 1 day, your account is locked out for 1 day and you won't be able to
  // log in for that day.
  'loginFailMax'      => 6,
  'loginFailTime'     => 86400,

  'cookieName'        => 'zendto-session',
  // Get the value for the 'cookieSecret' from this command:
  // /opt/zendto/sbin/genCookieSecret.php
  'cookieSecret'      => '11111111111111111111111111111111',
  'cookieTTL'         => '7200',

  // The virus scanner uses ClamAV. You need to get clamav, clamav-db and
  // clamd installed (all available from RPMForge). If you cannot get the
  // permissions working, even after reading the documentation on
  // www.zendto.com, then change the next line to '/usr/bin/clamscan --quiet'
  // and you will find it easier, though it will be a lot slower to scan.
  // If you need to disable virus scanning altogether, set this to 'DISABLED'.
  'clamdscan' => 'DISABLED',
 
);

// ----                                        ---- //
// ---- DO NOT CHANGE ANYTHING BELOW THIS LINE ---- //
// ----                                        ---- //

// Set definitions for AreYouAHuman.com CAPTCHA.
define('AYAH_PUBLISHER_KEY', $NSSDROPBOX_PREFS['ayah_publisher_key']);
define('AYAH_SCORING_KEY',   $NSSDROPBOX_PREFS['ayah_scoring_key']);
define('AYAH_WEB_SERVICE_HOST', 'ws.areyouahuman.com');
define('AYAH_TIMEOUT', 0);
define('AYAH_DEBUG_MODE', FALSE);
define('AYAH_USE_CURL', TRUE);

// Do *not* change the next line. 
require_once(NSSDROPBOX_LIB_DIR.SqlBackend.'.php');
