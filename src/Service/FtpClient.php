<?php declare(strict_types=1);

namespace App\Service;

use App\Service\Exception\FtpClientException;

class FtpClient
{
    private string $host;

    private int $port;

    private string $path;

    private int $timeout;

    private string $username;

    private string $password;

    private bool $isPassive;

    private $ftp;

    public function __construct(string $host, int $port, string $path, int $timeout, string $username, string $password, bool $isPassive)
    {
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->timeout = $timeout;
        $this->username = $username;
        $this->password = $password;
        $this->isPassive = $isPassive;
    }

    public function upload(string $remoteFileName, string $localFileName, int $mode = FTP_ASCII): void
    {
        if (($this->ftp = ftp_ssl_connect($this->host, $this->port, $this->timeout)) === false) {
            throw new FtpClientException(sprintf('Не удалось соединиться с сервером host %s port %s timeout %s', $this->host, $this->port, $this->timeout));
        }

        if (!ftp_login($this->ftp, $this->username, $this->password)) {
            throw new FtpClientException(sprintf('Не удалось залогиниться username %s password %s', $this->username, $this->password));
        }

        if ($this->isPassive && !ftp_pasv($this->ftp, true)) {
            throw new FtpClientException(sprintf('Не удалось установить пасивный режим'));
        }

        if (!ftp_put($this->ftp, $this->path . $remoteFileName, $localFileName, $mode)) {
            throw new FtpClientException(sprintf('Не удалось загрузить файл %s на сервер в %s', $localFileName, $this->path . $remoteFileName));
        }

        if (!ftp_close($this->ftp)) {
            throw new FtpClientException(sprintf('Не удалось разорвать соединение с сервером'));
        }

        return;
    }
}
