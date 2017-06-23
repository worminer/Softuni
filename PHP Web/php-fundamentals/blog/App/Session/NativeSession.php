<?php


namespace MVC\Session;

/**
 * Class NativeSession
 * @package MVC\Session
 */
class NativeSession implements SessionInterface
{

    private $lifeTime = null;
    /**
     * NativeSession constructor.
     * @param string $name
     * @param int $lifetime
     * @param string|null $path
     * @param string|null $domain
     * @param bool $secure
     */
    public function __construct(string $name, int $lifetime = 3600, string $path = null, string $domain = null, bool $secure = false)
    {
        if (strlen($name) < 1) {
            $name = "_sess";
        }
        $this->lifeTime = $lifetime;
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);
        session_start();
    }

    /**
     *
     */
    public function getSessionId()
    {
        return session_id();
    }

    /**
     *
     */
    public function saveSession()
    {
        session_write_close();
    }

    /**
     *
     */
    public function destroySession()
    {
        session_destroy();
    }

    /**
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getLifeTime()
    {
       return $this->lifeTime;
    }
}