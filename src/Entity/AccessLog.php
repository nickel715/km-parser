<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccessLogRepository")
 */
class AccessLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $remote_host;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_ident;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $auth_user;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $method;

    /**
     * @ORM\Column(type="string", length=8177)
     */
    private $request_path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $http_version;

    /**
     * @ORM\Column(type="integer")
     */
    private $server_response;

    /**
     * @ORM\Column(type="integer")
     */
    private $response_size;

    public function getId()
    {
        return $this->id;
    }

    public function getRemoteHost(): ?string
    {
        return $this->remote_host;
    }

    public function setRemoteHost(string $remote_host): self
    {
        $this->remote_host = $remote_host;

        return $this;
    }

    public function getClientIdent(): ?string
    {
        return $this->client_ident;
    }

    public function setClientIdent(?string $client_ident): self
    {
        $this->client_ident = $client_ident;

        return $this;
    }

    public function getAuthUser(): ?string
    {
        return $this->auth_user;
    }

    public function setAuthUser(?string $auth_user): self
    {
        $this->auth_user = $auth_user;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getRequestPath(): ?string
    {
        return $this->request_path;
    }

    public function setRequestPath(string $request_path): self
    {
        $this->request_path = $request_path;

        return $this;
    }

    public function getHttpVersion(): ?string
    {
        return $this->http_version;
    }

    public function setHttpVersion(string $http_version): self
    {
        $this->http_version = $http_version;

        return $this;
    }

    public function getServerResponse(): ?int
    {
        return $this->server_response;
    }

    public function setServerResponse(int $server_response): self
    {
        $this->server_response = $server_response;

        return $this;
    }

    public function getResponseSize(): ?int
    {
        return $this->response_size;
    }

    public function setResponseSize(int $response_size): self
    {
        $this->response_size = $response_size;

        return $this;
    }
}
