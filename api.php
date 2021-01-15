<?php
/**************************************************
 * MKOnlinePlayer v2.4
 * 后台音乐数据抓取模块
 * 编写：mengkun(https://mkblog.cn)
 * 时间：2018-3-11
 * 特别感谢 @metowolf 提供的 Meting.php
 *************************************************/

/************ ↓↓↓↓↓ 如果网易云音乐歌曲获取失效，请将你的 COOKIE 放到这儿 ↓↓↓↓↓ ***************/
$netease_cookie = '_iuqxldmzr_=32; _ntes_nnid=66a93d21d4fa158becfd750e0ec60045,1609103573868; _ntes_nuid=66a93d21d4fa158becfd750e0ec60045; NMTID=00OxxTqhUYNWb8kgk-jnodh3i4eCocAAAF2pgv9xQ; WM_TID=oEywfJc6omZBRVRVREJveck4UaUVOFQZ; __remember_me=true; MUSIC_U=4765110d68666184f39fe9e11d0dced630f8a16475cfbcecb08b5b8e7a9a72a333a649814e309366; __csrf=741aee72b37311725b911be9821eb9c0; ntes_kaola_ad=1; NTES_SESS=HuIJ4YUehEzAQFbp5HTqIULflHdDWKNZoVzZizLm_0bSUGQvUZBPoChPP.e_wttoY__qCmL4Fv4JQtobF574cEztPyKX2dFPJVv2iWX5h5vtuO6_SoQEDUxdt5klzkOSVYXwVKHrEGPAtToPNWImbDezhg.QvLs570r_IOBjezKCSYmUerAOhrAKGC4ibINDtgTsIIHh7EUymoKtZg_w.VvM6; NTES_PASSPORT=oqCDwlUZv.jfQ8dhSiqzPtgxEgSZlWZSM3ve8PjrjsGlxaw1xYbLveYEIT0mxi2OmcXY7AB2KhhSwA11oNfTVWaHlO1Z4uelz0Z5E5.VsSwrOmdJDTM0KcdTB9Q5BZfQ0R.YuValFqg88GtR._bd4Fijf8.VoM5d98seYa7vTqQhKgmaZ_Im3NtKL; S_INFO=1609784841|0|3&80##|rv5460; P_INFO=rv5460@163.com|1609784841|1|163|00&99|gud&1609784772&mail_free#gud&440600#10#0#0|138474&0|mail_free|rv5460@163.com; playliststatus=visible; outlink_h=1154; MUSIC_EMAIL_U=fdd6d4a9a4ec321999dcb9d14e06692fe82562bbf8998e1088aaadcf655bfa7672f6cfcfa67ffd37de39c620ce8469a8; playerid=55346309; WM_NI=bKN4O8ov7B53Sbcrt4A3l4Gtyk4nRyOY3SZDuZ0IwtEJyUAwuq2dADoUIzbtJqewhwjWWH2m%2F13%2BQqVFRwfqBYhsiem38Gl40silIGQoefQ%2Fct%2B2RLdvHY%2BSjMy%2B7uMVY0I%3D; WM_NIKE=9ca17ae2e6ffcda170e2e6ee90aa74b69dbf93f45ab2b48fa6c54f968f9eaab545a6a99ad5db62f7908fd3d82af0fea7c3b92aa29582d5ce34adaaf9a3b83991bead93f74083eda4d5c680bbb5fc8fd1738d87fdb4d950b78600aaf6808796b7b6c47db7affe85c450ad8b879be1808aafab98eb7daa8999a9b167edeffdccd47b969a9e98e57b8287a894ec6fafedf8a8ef40f4ada78dcc4d93b1ab87d425a1ace5d3d148a8aa88baaa59aa93b7ccb67f8f8a97d1cc37e2a3; JSESSIONID-WYYY=RNuV8sZ%2BQBXsdOARrr7C79O%5CWfetaRSIetcYmmh4SP4iQROUrc6OYgh%2BrXlBly5johOV6lX%2BUWotSRJt%2F5y%5C7Bf%2BjubMHcMFmCyTIVZev4bZD584XbG1W5o8XCFgX1XB1MVRRkrEtcwWXy%2FwYhO7cjoCyRyR8Bs34UngIGcqorslfMwV%3A1610091656507';
/************ ↑↑↑↑↑ 如果网易云音乐歌曲获取失效，请将你的 COOKIE 放到这儿 ↑↑↑↑↑ ***************/
/**
* cookie 获取及使用方法见 
* https://github.com/mengkunsoft/MKOnlineMusicPlayer/wiki/%E7%BD%91%E6%98%93%E4%BA%91%E9%9F%B3%E4%B9%90%E9%97%AE%E9%A2%98
* 
* 更多相关问题可以查阅项目 wiki 
* https://github.com/mengkunsoft/MKOnlineMusicPlayer/wiki
* 
* 如果还有问题，可以提交 issues
* https://github.com/mengkunsoft/MKOnlineMusicPlayer/issues
**/


define('HTTPS', false);    // 如果您的网站启用了https，请将此项置为“true”，如果你的网站未启用 https，建议将此项设置为“false”
define('DEBUG', false);      // 是否开启调试模式，正常使用时请将此项置为“false”
define('CACHE_PATH', 'cache/');     // 文件缓存目录,请确保该目录存在且有读写权限。如无需缓存，可将此行注释掉

/*
 如果遇到程序不能正常运行，请开启调试模式，然后访问 http://你的网站/音乐播放器地址/api.php ，进入服务器运行环境检测。
 此外，开启调试模式后，程序将输出详细的运行错误信息，方便定位错误原因。
 
 因为调试模式下程序会输出服务器环境信息，为了您的服务器安全，正常使用时请务必关闭调试。
*/



/*****************************************************************************************************/
if(!defined('DEBUG') || DEBUG !== true) error_reporting(0); // 屏蔽服务器错误

require_once('plugns/Meting.php');

use Metowolf\Meting;

$source = getParam('source', 'netease');  // 歌曲源
$API = new Meting($source);

$API->format(true); // 启用格式化功能

if($source == 'kugou' || $source == 'baidu') {
    define('NO_HTTPS', true);        // 酷狗和百度音乐源暂不支持 https
} elseif(($source == 'netease') && $netease_cookie) {
    $API->cookie($netease_cookie);    // 解决网易云 Cookie 失效
}

// 没有缓存文件夹则创建
if(defined('CACHE_PATH') && !is_dir(CACHE_PATH)) createFolders(CACHE_PATH);

$types = getParam('types');
switch($types)   // 根据请求的 Api，执行相应操作
{
    case 'url':   // 获取歌曲链接
        $id = getParam('id');  // 歌曲ID
        
        $data = $API->url($id);
        
        echojson($data);
        break;
        
    case 'pic':   // 获取歌曲链接
        $id = getParam('id');  // 歌曲ID
        
        $data = $API->pic($id);
        
        echojson($data);
        break;
    
    case 'lyric':       // 获取歌词
        $id = getParam('id');  // 歌曲ID
        
        if(($source == 'netease') && defined('CACHE_PATH')) {
            $cache = CACHE_PATH.$source.'_'.$types.'_'.$id.'.json';
            
            if(file_exists($cache)) {   // 缓存存在，则读取缓存
                $data = file_get_contents($cache);
            } else {
                $data = $API->lyric($id);
                
                // 只缓存链接获取成功的歌曲
                if(json_decode($data)->lyric !== '') {
                    file_put_contents($cache, $data);
                }
            }
        } else {
            $data = $API->lyric($id);
        }
        
        echojson($data);
        break;
        
    case 'download':    // 下载歌曲(弃用)
        $fileurl = getParam('url');  // 链接
        
        header('location:$fileurl');
        exit();
        break;
    
    case 'userlist':    // 获取用户歌单列表
        $uid = getParam('uid');  // 用户ID
        
        $url= 'http://music.163.com/api/user/playlist/?offset=0&limit=1001&uid='.$uid;
        $data = file_get_contents($url);
        
        echojson($data);
        break;
        
    case 'playlist':    // 获取歌单中的歌曲
        $id = getParam('id');  // 歌单ID
        
        if(($source == 'netease') && defined('CACHE_PATH')) {
            $cache = CACHE_PATH.$source.'_'.$types.'_'.$id.'.json';
            
            if(file_exists($cache) && (date("Ymd", filemtime($cache)) == date("Ymd"))) {   // 缓存存在，则读取缓存
                $data = file_get_contents($cache);
            } else {
                $data = $API->format(false)->playlist($id);
                
                // 只缓存链接获取成功的歌曲
                if(isset(json_decode($data)->playlist->tracks)) {
                    file_put_contents($cache, $data);
                }
            }
        } else {
            $data = $API->format(false)->playlist($id);
        }
        
        echojson($data);
        break;
     
    case 'search':  // 搜索歌曲
        $s = getParam('name');  // 歌名
        $limit = getParam('count', 20);  // 每页显示数量
        $pages = getParam('pages', 1);  // 页码
        
        $data = $API->search($s, [
            'page' => $pages, 
            'limit' => $limit
        ]);
        
        echojson($data);
        break;
        
    default:
        echo '<!doctype html><html><head><meta charset="utf-8"><title>信息</title><style>* {font-family: microsoft yahei}</style></head><body> <h2>MKOnlinePlayer</h2><h3>Github: https://github.com/mengkunsoft/MKOnlineMusicPlayer</h3><br>';
        if(!defined('DEBUG') || DEBUG !== true) {   // 非调试模式
            echo '<p>Api 调试模式已关闭</p>';
        } else {
            echo '<p><font color="red">您已开启 Api 调试功能，正常使用时请在 api.php 中关闭该选项！</font></p><br>';
            
            echo '<p>PHP 版本：'.phpversion().' （本程序要求 PHP 5.4+）</p><br>';
            
            echo '<p>服务器函数检查</p>';
            echo '<p>curl_exec: '.checkfunc('curl_exec',true).' （用于获取音乐数据）</p>';
            echo '<p>file_get_contents: '.checkfunc('file_get_contents',true).' （用于获取音乐数据）</p>';
            echo '<p>json_decode: '.checkfunc('json_decode',true).' （用于后台数据格式化）</p>';
            echo '<p>hex2bin: '.checkfunc('hex2bin',true).' （用于数据解析）</p>';
            echo '<p>openssl_encrypt: '.checkfunc('openssl_encrypt',true).' （用于数据解析）</p>';
        }
        
        echo '</body></html>';
}

/**
 * 创建多层文件夹 
 * @param $dir 路径
 */
function createFolders($dir) {
    return is_dir($dir) or (createFolders(dirname($dir)) and mkdir($dir, 0755));
}

/**
 * 检测服务器函数支持情况
 * @param $f 函数名
 * @param $m 是否为必须函数
 * @return 
 */
function checkfunc($f,$m = false) {
	if (function_exists($f)) {
		return '<font color="green">可用</font>';
	} else {
		if ($m == false) {
			return '<font color="black">不支持</font>';
		} else {
			return '<font color="red">不支持</font>';
		}
	}
}

/**
 * 获取GET或POST过来的参数
 * @param $key 键值
 * @param $default 默认值
 * @return 获取到的内容（没有则为默认值）
 */
function getParam($key, $default='')
{
    return trim($key && is_string($key) ? (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default)) : $default);
}

/**
 * 输出一个json或jsonp格式的内容
 * @param $data 数组内容
 */
function echojson($data)    //json和jsonp通用
{
    header('Content-type: application/json');
    $callback = getParam('callback');
    
    if(defined('HTTPS') && HTTPS === true && !defined('NO_HTTPS')) {    // 替换链接为 https
        $data = str_replace('http:\/\/', 'https:\/\/', $data);
        $data = str_replace('http://', 'https://', $data);
    }
    
    if($callback) //输出jsonp格式
    {
        die(htmlspecialchars($callback).'('.$data.')');
    } else {
        die($data);
    }
}
