<?php
/*
The ChaCha20 logic for this PHP example is credited to:  
Discord: SmallGarfield#4404   
GitHub: https://github.com/xiaojiafei520
*/
class Context
{
    public $state;
    public $buffer = '';
}
class Cipher
{
    function init(string $key, string $nonce): Context
    {
        if (strlen($key) !== 32) {
            throw new \LengthException('Key must be a 256-bit string');
        }

        if (strlen($nonce) !== 12) {
            throw new \LengthException('Nonce must be a 96-bit string');
        }

        $ctx = new Context();
        $ctx->state = array_values(unpack('V16', "expand 32-byte k$key\0\0\0\0$nonce"));

        return $ctx;
    }

    function encrypt(Context $ctx, string $message): string
    {
        $state = $ctx->state;
        $keyStream = $ctx->buffer;

        $bytesRequired = strlen($message) - strlen($keyStream);
        $bytesOver = $bytesRequired % 64;

        $blocks = ($bytesRequired >> 6) + ($bytesOver > 0);
        while ($blocks-- > 0) {
            list($s00, $s01, $s02, $s03, $s04, $s05, $s06, $s07, $s08, $s09, $s10, $s11, $s12, $s13, $s14, $s15) = $state;

            $i = 10;
            while ($i--) {
                $s04 = ((($c = $s04 ^ ($s08 += ($s12 = (((
                          $c = $s12 ^ ($s00 += ($s04 = (((
                          $c = $s04 ^ ($s08 += ($s12 = (((
                          $c = $s12 ^ ($s00 +=  $s04) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s05 = ((($c = $s05 ^ ($s09 += ($s13 = (((
                          $c = $s13 ^ ($s01 += ($s05 = (((
                          $c = $s05 ^ ($s09 += ($s13 = (((
                          $c = $s13 ^ ($s01 +=  $s05) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s06 = ((($c = $s06 ^ ($s10 += ($s14 = (((
                          $c = $s14 ^ ($s02 += ($s06 = (((
                          $c = $s06 ^ ($s10 += ($s14 = (((
                          $c = $s14 ^ ($s02 +=  $s06) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s07 = ((($c = $s07 ^ ($s11 += ($s15 = (((
                          $c = $s15 ^ ($s03 += ($s07 = (((
                          $c = $s07 ^ ($s11 += ($s15 = (((
                          $c = $s15 ^ ($s03 +=  $s07) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s05 = ((($c = $s05 ^ ($s10 += ($s15 = (((
                          $c = $s15 ^ ($s00 += ($s05 = (((
                          $c = $s05 ^ ($s10 += ($s15 = (((
                          $c = $s15 ^ ($s00 +=  $s05) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s06 = ((($c = $s06 ^ ($s11 += ($s12 = (((
                          $c = $s12 ^ ($s01 += ($s06 = (((
                          $c = $s06 ^ ($s11 += ($s12 = (((
                          $c = $s12 ^ ($s01 +=  $s06) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s07 = ((($c = $s07 ^ ($s08 += ($s13 = (((
                          $c = $s13 ^ ($s02 += ($s07 = (((
                          $c = $s07 ^ ($s08 += ($s13 = (((
                          $c = $s13 ^ ($s02 +=  $s07) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;

                $s04 = ((($c = $s04 ^ ($s09 += ($s14 = (((
                          $c = $s14 ^ ($s03 += ($s04 = (((
                          $c = $s04 ^ ($s09 += ($s14 = (((
                          $c = $s14 ^ ($s03 +=  $s04) & 0xffffffff) << 16) & 0xffffffff) | $c >> 16))
                                                      & 0xffffffff) << 12) & 0xffffffff) | $c >> 20))
                                                      & 0xffffffff) <<  8) & 0xffffffff) | $c >> 24))
                                                      & 0xffffffff) <<  7) & 0xffffffff) | $c >> 25;
            }

            $keyStream .= pack('V16',
                $s00 + $state[ 0],
                $s01 + $state[ 1],
                $s02 + $state[ 2],
                $s03 + $state[ 3],
                $s04 + $state[ 4],
                $s05 + $state[ 5],
                $s06 + $state[ 6],
                $s07 + $state[ 7],
                $s08 + $state[ 8],
                $s09 + $state[ 9],
                $s10 + $state[10],
                $s11 + $state[11],
                $s12 + $state[12],
                $s13 + $state[13],
                $s14 + $state[14],
                $s15 + $state[15]
            );

            if (++$state[12] & 0xf00000000) {
                throw new \OverflowException('Counter overflowed upper bound');
            }
        }

        $ctx->buffer = substr($keyStream, $bytesRequired);
        $ctx->state = $state;

        return $message ^ $keyStream;
    }

    public function decrypt(Context $ctx, string $message): string
    {
        return $this->encrypt($ctx, $message);
    }

    public function setCounter(Context $ctx, int $counter)
    {
        if ($counter < 0 || $counter > 0xffffffff) {
            throw new \InvalidArgumentException('Counter must be 32-bit positive integer');
        }

        $ctx->state[12] = $counter;
        $ctx->buffer = '';
    }
}
class MyChaCha20
{
    function chacha20_encrypt(string $plaintext, string $key, string $nonce, bool $base64, int $initialcounter): string
    {
        if($base64)
        {
            //$plaintext = base64_decode($plaintext);
            $key = base64_decode($key);
            $nonce = base64_decode($nonce);
        }
        
        $cipher = new Cipher();
        $context = $cipher->init($key, $nonce);
        $cipher->setCounter($context, $initialcounter);
        $ciphertext = $cipher->encrypt($context, $plaintext);
            
        if($base64)
        {
            return base64_encode($ciphertext);
        }else {
            return $ciphertext;
        }
    }

    function chacha20_decrypt(string $ciphertext,string $key, string $nonce, bool $base64, int $initialcounter): string
    {
        if($base64)
        {
            $ciphertext = base64_decode($ciphertext);
            $key = base64_decode($key);
            $nonce = base64_decode($nonce);
        }
        $cipher = new Cipher();
        $context = $cipher->init($key, $nonce);
        $cipher->setCounter($context, $initialcounter);
        $plaintext = $cipher->decrypt($context, $ciphertext);
        return $plaintext;
    }
}