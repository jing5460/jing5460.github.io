<?php
/**************************************************
 * MKOnlinePlayer v2.4
 * 后台音乐数据抓取模块
 * 编写：mengkun(https://mkblog.cn)
 * 时间：2018-3-11
 * 特别感谢 @metowolf 提供的 Meting.php
 *************************************************/

/************ ↓↓↓↓↓ 如果网易云音乐歌曲获取失效，请将你的 COOKIE 放到这儿 ↓↓↓↓↓ ***************/
$netease_cookie = '_ntes_nnid=6a42f99f648e52d10f1ef781c9d6900f,1650533393062; _ntes_nuid=6a42f99f648e52d10f1ef781c9d6900f; _fbp=fb.1.1652855891231.6080038; _ns=NS1.2.590069290.1654504295; NMTID=00OrQCbEgjaSdIRvE6rjYHMlnYXRqQAAAGCLJjPPw; WEVNSM=1.0.0; WNMCID=igalja.1658605590618.01.0; WM_TID=C%2FWcv5dlbvREUAUBUEKRUDDaPzDtXQ4R; WM_NI=rWlrvYd1TsIY%2BhlmRcCnvYT5u6%2F64NFyk0F19zdbJKwb9yB8HL6epQY73N8GMpJ2%2FBG%2B2qMtH2QiH5qLV0Q2C4Ybxjgqbycx0FxlBlqkRhl%2FZgBKua2mpUR0%2FI1422F3aW4%3D; WM_NIKE=9ca17ae2e6ffcda170e2e6ee87ee638fb0a0a9c46d90b48fa3d15a929e9ab1d15d92a7008dbc4dabbd98aae82af0fea7c3b92ab289a493f553a8ef9c94cc53e9b8a48ed16981b2babad73fb7eae1d7b74686a7a5d1c53bfba6ac83c941b5bef79ac1348c94fa86f35b9be9fdafbb4d8fb086d3ae4a85f5fe92d0808cee9f8acb3fb3949ad1d43a81ec9783fb62a5afae9ae274f49ab88dc168b3b59e89ef259ab98eacf86bf2b3c0b6d13ced97ffd5b13a86edafb8b737e2a3; JSESSIONID-WYYY=EuFdpqu4tacpaTiTpq7Rwt98jh5kqOv%2BcjtCuayIEsNnnDwTcEFdT2ieXbeDn%2B95OQe0s0m4%5C94oAqTevGldAwuezkapZUvg6zx6fZUuem1ICtIO%2BRIxqrZbG%5CfPVDaK9oBMd6e%2BbNcKd%2FgAiM%2FxWZhb3X%2BUnXJ4PXIVIAEv8x6o%2BrsT%3A1658607392241; _iuqxldmzr_=33; __snaker__id=bXrXreqOr6Ip7iCQ; gdxidpyhxdE=%2FquToQ%5Cf2uqva%2FcuUlekiuGjXR7rc5NBko1iE9wVqzeIl36XK3mS11f3aX2n4JY2B5puZ%5CgfxhXtDvcz3HJeatPznKxbPPvglxBxWbQVLMY%2B9VnhRv7bvDmYQNLeV8irlhL%5C%2B%2Br9JNP1XDJSbz6LcjzMG2zPCJL%2Fgc8EpMISuLGlbzPl%3A1658606497095; _9755xjdesxxd_=32; YD00000558929251%3AWM_NI=YU4x8eOT8dLOX0tDpPbO%2BjvhgUiffQRI2MgZ%2F751qiBDyx%2FZYitFWfT1uQ%2FHMWX0Kb9OWVBGU8cs4hE5EMjwURHnVrkpFQOO0wuIRIZGdXCqXPKAj%2FS0%2B0WvCl6xjUM3N1A%3D; YD00000558929251%3AWM_NIKE=9ca17ae2e6ffcda170e2e6eeaee76d949bfd8af27083868eb6d44a939a9a83d85482a6a48df350b1b2b884f22af0fea7c3b92a9b8bfc99bb6f8d8cf885cf459cf0bca5f35ca291e58bf564a58ba787e55b9297feaee652ede9fbd2f463829cb799ae529bb7bca7d66e98efbbb2ae448f8998d1ca6afb9199b7c14d97e8ad94b76487eb8baee97d978e888fd57aa9b08ab2ce45f4a9bbaad1439a99acb9c27b9c9085a2e92591f0e5d1d67e81b4fa99e95f8fed82d2c437e2a3; YD00000558929251%3AWM_TID=%2F0nH9phAL%2BRAUEQAFBeEXEnkxpW9ildp; __csrf=5a3c17992d04efa366f10c1921704a86; MUSIC_U=4765110d68666184f39fe9e11d0dced6e1a09a428e19c1d41aa0b55554ddac64519e07624a9f005347b22c32f20915e4ec4a97fde7f952743b6005f12cf27b5646ed1801b49e6e721b93ac14e0ed86ab; __remember_me=true; ntes_kaola_ad=1';
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
