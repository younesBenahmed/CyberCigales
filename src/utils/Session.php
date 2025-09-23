<?php

final class Session {

    public static function start() {
        session_start();
        $_SESSION['suid'] = session_id();
    }
    public static function destroy() {
        session_start();
        unset($_SESSION['suid']);
    }

}
