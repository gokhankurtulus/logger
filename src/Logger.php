<?php
/**
 * @author Gökhan Kurtuluş @gokhankurtulus
 * Date: 28.12.2023 Time: 02:23
 */

namespace Logger;
class Logger
{
    private static string $defaultFolderPath = __DIR__ . DIRECTORY_SEPARATOR . "Logs";
    protected static string $folderPath = __DIR__ . DIRECTORY_SEPARATOR . "Logs";
    protected static string $fileName = "app.log";

    /**
     * @param string $message
     * @param string $title
     * @return false|int
     */
    public static function log(string $message, string $title = ""): false|int
    {
        $logFilePath = static::getFolderPath() . DIRECTORY_SEPARATOR . static::getFileName();
        $date = new \DateTime();
        $timeZone = date_default_timezone_get();
        $logData = PHP_EOL . "[{$date->format("d-m-Y H:i:s")} - $timeZone] - $title" . PHP_EOL . $message . PHP_EOL;
        return @file_put_contents($logFilePath, $logData, FILE_APPEND);
    }

    /**
     * @param bool $logErrors
     * @param bool $displayErrors
     * @param int|null $error_level
     * @return bool
     */
    public static function iniSet(bool $logErrors = true, bool $displayErrors = true, ?int $error_level = E_ALL): bool
    {
        if (class_parents(static::class)) {
            return false;
        }
        $error_log_res = (bool)ini_set('error_log', static::getFolderPath() . DIRECTORY_SEPARATOR . static::getFileName());
        $log_errors_res = (bool)ini_set('log_errors', $logErrors);
        $display_errors_res = (bool)ini_set('display_errors', $displayErrors);
        $error_reporting_res = (bool)error_reporting($error_level);
        return $error_log_res && $log_errors_res && $display_errors_res && $error_reporting_res;
    }

    private static function getDefaultFolderPath(): string
    {
        return static::$defaultFolderPath;
    }

    private static function setDefaultFolderPath(string $defaultFolderPath): void
    {
        static::$defaultFolderPath = $defaultFolderPath;
    }

    public static function getFolderPath(): string
    {
        return static::$folderPath ?: static::getDefaultFolderPath();
    }

    public static function setFolderPath(string $folderPath): void
    {
        if (!class_parents(static::class)) {
            static::setDefaultFolderPath($folderPath);
        }
        if (!static::isFolderExist($folderPath)) {
            mkdir($folderPath, 0777);
        }
        static::$folderPath = $folderPath;
    }

    public static function getFileName(): string
    {
        return static::$fileName;
    }

    public static function setFileName(string $fileName): void
    {
        static::$fileName = $fileName;
    }

    protected static function isFolderExist(string $path): bool
    {
        return is_dir($path);
    }

    protected static function isFileExist(string $file): bool
    {
        return file_exists($file);
    }
}