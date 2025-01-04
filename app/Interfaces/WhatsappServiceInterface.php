<?php

namespace App\Interfaces;

interface WhatsappServiceInterface {
    public static function getAllInstances();
    public static function instanceConnect($instanceName);
    public static function createInstance(array $data);
    public static function restartInstance($instanceName);
    public static function logoutInstance($instanceName);
    public static function deleteInstance($instanceName);
    public static function setProxyInstance($instanceName, $data);
    public static function setWebsocketInstance($instanceName, $data);
    public static function setSettingsInstance($instanceName, $data);
    public static function checkWhatsappNumber($phone);

    public static function sendMessage($instanceName, $phone, $message);

    public static function getMessages($instanceName);
    public static function getChats($instanceName);
}