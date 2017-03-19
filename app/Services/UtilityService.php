<?php

namespace App\Services;

/**
 * ユーティティサービス
 * 
 * @author Kuniyasu Wada
 */
class UtilityService
{
    /**
     * Get Current Time...
     *
     * @param  $format = "Y-m-d H:i:s"など
     * @param  $date
     * @return string 日付データ
     */
    public function getDate($format = 'Y-m-d H:i:s', $date = null)
    {
        $Carbon = is_null($date) ? \Carbon::now() : new Carbon($date);
        return $Carbon->format($format);
    }

    /**
     * 29時間形式を24時間形式へ変換する
     *
     * @param  $date
     * @param  $time
     * @param  $isIrregular (BAMPからは日付が20160816、時間が2147など、変則的なため)
     * @return string 日付
     * @author Kuniyasu Wada
     */
    public function convert29DateTo24Date($date, $time, $isIrregular = false)
    {
        if(empty($date)) return;
        
        if($isIrregular)
        {
            $time = empty($time) ? '0000' : $time;
            $arrTime[0] = mb_substr($time, 0, 2);
            $arrTime[1] = mb_substr($time, 2, 2);
            $arrTime[2] = '00';
        }
        else {
            $time = empty($time) ? '00:00:00' : $time;
            $arrTime = explode(':', $time);
        }
        
        if( intval($arrTime[0]) >= 24 && intval($arrTime[0]) <= 29)
        {
            $arrTime[0] = intval($arrTime[0]) - 24;
            $date = \Carbon::parse($date)->addDay(1)->format('Y-m-d');
        }
        
        return \Carbon::parse("$date {$arrTime[0]}:{$arrTime[1]}:{$arrTime[2]}");
    }

    /**
     * 24時間形式を29時間形式へ変換する
     *
     * @param  $datetime
     * @param  $isEnd 開始・終了のどちらを意味するか
     * @return string 日付データ
     * @author Kuniyasu Wada
     */
    public function convert24DateTo29Date($date, $time, $isEnd = false)
    {
        $time = empty($time) ? '00:00:00' : $time;
        $Carbon = \Carbon::parse($date.$time);
        $arrTime = explode(':', $time);
        
        // 00:00:00 ～ 04:59:59 または、"終了時間"かつ "05:00:00" なら29時間形式へ変換
        if( ("{$date} 00:00:00" <= $Carbon->format('Y-m-d H:i:s') && $Carbon->format('Y-m-d H:i:s') < "{$date} 05:00:00")
            || ( $time === "05:00:00" && $isEnd ) )
        {
            $arrTime[0] = intval($arrTime[0]) + 24;
            $date = $Carbon->subDay(1)->format('Y-m-d');
        }
        
        return "$date {$arrTime[0]}:{$arrTime[1]}:{$arrTime[2]}";
    }

    /**
     * HH:MM:SS 形式の動画尺等を秒単位に変換する
     *
     * @param  $time
     * @return float
     */
    public function timeToSecond($time)
    {
        $arrTime = explode(':', $time);
        if( count($arrTime) < 3 ) return $time;
        return (intval($arrTime[0]) * 3600) + (intval($arrTime[1]) * 60) + intval($arrTime[2]);
    }

    /**
     * ブライトコーブAPI 動画登録時のキューポイント指定用に
     * HH:MM:SS.mmm 形式の文字列を、秒単位に変換して、
     * ミリ秒を結合してFloat型にキャストして返す
     *
     * @param  $time
     * @return float
     */
    public function timeToMillisecond($time)
    {
        $arrTime1 = explode('.', $time);
        $arrTime2 = explode(':', $arrTime1[0]);
        
        // 正しく分割出来ていない場合はリターン
        if( count($arrTime1) < 2 || count($arrTime2) < 3 ) return null;
        
        $second = (intval($arrTime2[0]) * 3600) + (intval($arrTime2[1]) * 60) + intval($arrTime2[2]);
        $strTime = $second . '.' . $arrTime1[1];
        
        return floatval($strTime);
    }

    /**
     * GYAO! MRSS出力用
     * 'H:i:s'形式の時間を、'H:i'にして返す
     *
     * @param  string $year
     * @param  string $default
     * @return array
     */
    public function explodeTimeForMrss($time)
    {
        $arrTime = explode(':', $time);
        if( count($arrTime) < 2 ) return false;
        
        return $arrTime[0]. ':' .$arrTime[1];
    }

    /**
     * 2つの指定する日付の間かどうか判定する
     *
     * @param  Carbon $start
     * @param  Carbon $end
     * @param  Carbon $target
     * @param  bool $equal Y-m-dなどの場合、当日を含むかどうか
     * @return array
     */
    public function isBetween($start, $end, $target = null, $equal = true)
    {
        $target = ( is_null($target) ) ? \Carbon::now() : \Carbon::parse($target);
        return $target->between( \Carbon::parse($start), \Carbon::parse($end), $equal );
    }

    /**
     * 基準日が対象日の前かどうか判定する
     *
     * @param  Carbon $target 対象日
     * @param  Carbon $baseDay 基準日
     * @param  bool $equal Y-m-dなどの場合、当日を含むかどうか
     * @return array
     */
    public function isBefore($target, $baseDay = null, $equal = true)
    {
        $baseDay = ( is_null($baseDay) ) ? \Carbon::now() : \Carbon::parse($baseDay);
        
        if( $equal )
            return $baseDay->lte( \Carbon::parse($target) );
        else 
            return $baseDay->lt( \Carbon::parse($target) );
    }

    /**
     * 基準日が対象日の後かどうか判定する
     *
     * @param  Carbon $target 対象日
     * @param  Carbon $baseDay 基準日
     * @param  bool $equal Y-m-dなどの場合、当日を含むかどうか
     * @return array
     */
    public function isAfter($target, $baseDay = null, $equal = true)
    {
        $baseDay = ( is_null($baseDay) ) ? \Carbon::now() : \Carbon::parse($baseDay);
        
        if( $equal )
            return $baseDay->gte( \Carbon::parse($target) );
        else 
            return $baseDay->gt( \Carbon::parse($target) );
    }

    /**
     * Get PullDown Years...
     * (デフォルトは現在年から未来5年分)
     * 
     * @param  string $year
     * @param  string $default
     * @return array
     */
    public function getArrYear($start = null, $cnt = null)
    {
        $year = !$start ? intval(DATE("Y")) : intval($start);
        $end_year = !$cnt ? DATE("Y") + 4 : DATE("Y") + (intval($cnt) - 1);
        
        $year_array = array();
        
        for ($i=$year; $i<=($end_year); $i++){
            $year_array[$i] = $i;
        }
        return $year_array;
    }

    /**
     * Generating Random Slug...
     * 
     * @param  number $length
     * @return string
     */
    public function getRandomSlug($length = 6)
    {
        $parts = 'abcefghijklmnopqrstuvwxyz1234567890';
        return substr(str_shuffle($parts), 0, $length);
    }

    /**
     * Output To File...
     * 
     * @param  string $data
     * @param  string $filepath
     * @param  string $mode
     * @return number
     */
    public function fwrite($data, $filepath, $mode = 'a+')
    {
        $fp = fopen($filepath, $mode);
        $res = fwrite($fp, $data. "\n");
        fclose($fp);
    
        return $res;
    }

    /**
     * 配列をデリミタで連結した文字列を返す
     *
     * @param  array   $params
     * @param  string  $delimiter
     * @return string $str
     */
    public function implodeArrToString($params, $delimiter)
    {
        $str = "";
        
        if(is_array($params))
        {
            foreach ($params as $key => $val)
            {
                if($str != "" && !empty($val)) $str .= "{$delimiter}";
                $str .= $val;
            }
        }
        else
            $str = $params;
        
        return $str;
    }

    /**
     * Get Salt...
     */
    public function get_salt() {
        $bytes = openssl_random_pseudo_bytes(SALT_LENGTH);
        return bin2hex($bytes);
    }

    /**
     * ソルト＋ストレッチングでハッシュ化したパスワードを取得
     */
    public function getHushPassword($salt, $pass){
        $hash_pass = "";
    
        for ($i = 0; $i < STRETCH_COUNT; $i++){
            $hash  = hash("sha256", ($hash_pass . $salt . $pass));
        }
        return $hash;
    }

    /**
     * Get CSRF Token... 
     */
    public function get_csrf_token() {
        $bytes = openssl_random_pseudo_bytes(TOKEN_LENGTH);
        return bin2hex($bytes);
    }

    /**
     * Do Redirect...
     */
    public function sendRedirect($url) {
        header("location: {$url}");
        exit();
    }

    /**
     * 指定階層まで遡ったパスを取得
     * 
     * @param  string $current カレントパス
     * @param  int $cnt 遡る階層数
     * @param  bool $full フルパスかどうか TRUE＝フルパス FALSE＝ディレクトリ名のみ
     * @return string
     * @author K.Wada
     */
    public function getBackDir($current, $cnt = 1, $full = TRUE)
    {
        $arrDir = explode('/', $current);
    
        // 指定回数分遡る
        for($i=0; $i < $cnt; $i++){
            array_pop($arrDir);
        }
        if($full){
            // フルパス
            $fullPath = implode('/', $arrDir);
            return $fullPath;
        }
        else {
            // ディレクトリ名
            $dirName = array_pop($arrDir);
            return $dirName;
        }
    }

    /**
     * 指定されたサーバー環境変数を取得する
     */
    public function getServer($key, $default = null)
    {
        return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
    }

    /**
     * セッションを安全かつ完全に破壊する
     * (セッションハイジャック対策)
     *
     * @return void
     * @author K.Wada
     */
    public function sessionDestroy()
    {
        // セッション変数を全て解除する
        $_SESSION = array();
    
        // セッションを切断するにはセッションクッキーも削除する。
        // セッションクッキーを有効期限外に設定
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        // 最終的に、セッションを破壊する
        session_destroy();
    }

    /**
     * クライアントのIPアドレスを取得する
     *
     * @param  string $checkProxy
     * @return Ambigous <unknown, string>
     */
    public function getClientIp($checkProxy = true)
    {
        /*
         *  プロキシサーバ経由の場合は、プロキシサーバではなく
         *  接続もとのIPアドレスを取得するために、サーバ変数
         *  HTTP_CLIENT_IP および HTTP_X_FORWARDED_FOR を取得する。
         */
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null){
            $ip = $this->getServer('HTTP_CLIENT_IP');
        }
        else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null){
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        }
        else {
            // プロキシサーバ経由でない場合は、REMOTE_ADDR から取得する
            $ip = $this->getServer('REMOTE_ADDR');
        }
        return $ip;
    }

    /**
     * 文字列をリプレースして返す
     *
     * @param  string $str
     * @param  array $arrReplace
     * @param  string $toReplace
     * @return string
     */
    public function filter($str, $arrReplace, $toReplace = '')
    {
        return str_replace($arrReplace, '', $str);
    }

    /**
     * 指定文字数を越えていたら指定文字数で切って、
     * オプション文字列を付加する
     *
     * @param  array   $params
     * @param  integer $length
     * @param  string  $string
     * @return string $str
     */
    public function cutString($string, $length, $append)
    {
        if( !is_numeric($length) || mb_strlen($string, "UTF-8") <= $length) return $string;
        
        $newStr = mb_substr($string, 0, $length, "UTF-8");
        return $newStr.$append;
    }

    /**
     * データを比較して変更のあったフィールドと値の配列を返す
     *
     * @param  array or object $old
     * @param  array or object $new
     * @return array
     */
    public function isModifidFieleds($old, $new)
    {
        $diff = [];
        $new  = is_array($new) ? $new : $new->toArray();
        $old  = is_array($old) ? $old : $old->toArray();
        
        foreach($new as $key => $val)
        {
            if( $old[$key] != $val )
                $diff[$key] = $val;
        }
        return $diff;
    }

    /**
     * マッピングしたカラム名で格納していく
     * 
     * @param  array $data
     * @param  array $keyMap
     * @param  array $inputs
     * @return void
     */
    public function mappingParam($data, $keyMap, $inputs = [])
    {
        foreach( $data as $key => $val )
        {
            // マッピング配列にキーがあれば格納
            if( array_key_exists($key, $keyMap) )
                $inputs[$keyMap[$key]] = $val;
        }
        return $inputs;
    }

    /**
     * ファイルの存在チェック
     * 
     * @param  string $filepath
     * @return bool
     */
    public function isExistsFile($filepath)
    {
        // 存在が確認出来れば良いので、httpレスポンスの最初の1文字だけ取得
        return @file_get_contents($filepath, NULL, NULL, 0, 1);
    }

    /**
     * ファイルのMIME TYPEを取得する
     *
     * @param  string $filepath
     * @return null|string
     */
    public function getMimeType($filepath)
    {
        // 存在確認
        if( ! @file_get_contents($filepath, NULL, NULL, 0, 1) ) return null;
        
        $img_data  = @file_get_contents($filepath);
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $img_data);
        finfo_close($finfo);
        
        return $mime_type;
    }

    /**
     * テストメール送信
     * 
     * @param $subject
     */
    public function sendTestMail($subject)
    {
        \Mail::queue('emails.default', [], function ($mail) use ($subject)
        {
            $mail->to('wada@n-di.co.jp', 'テスト');
            $mail->subject($subject);
        });
    }

}
