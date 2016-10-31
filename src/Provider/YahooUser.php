<?php
namespace Hayageek\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class YahooUser implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $response;


    /**
     * @var image URL
     */
    private $imageUrl;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response['profile'];
    }

    public function getId()
    {
        return isset($this->response['guid']) ? $this->response['guid'] : null;
    }

    /**
     * Get perferred display name.
     *
     * @return string|null
     */
    public function getName()
    {
        /*
        nickname is not coming in the response.
        $this->response['profile']['nickname']
        */
		$firstName = !is_null( $this->getFirstName() ) ? $this->getFirstName() : '';
		$lastName = !is_null( $this->getLastName() ) ? $this->getLastName() : '';

		$name = trim("$firstName $lastName");

        return !( empty($name) ) ? $name : null;
    }

    /**
     * Get nickname.
     *
     * @return string|null
     */
    public function getNickname()
    {
        return isset( $this->response['nickname'] ) ? $this->response['nickname'] : null;
    }

    /**
     * Get perferred first name.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return isset( $this->response['givenName'] ) ? $this->response['givenName'] : null;
    }

    /**
     * Get perferred last name.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return isset( $this->response['familyName'] ) ? $this->response['familyName'] : null;
    }

    /**
     * Get email address.
     *
     * @return string|null
     */
    public function getEmail()
    {
		return isset( $this->response['emails'] ) ? $this->response['emails'][0]['handle'] : null;
    }

    /**
     * Get profile url.
     *
     * @return string|null
     */
    public function getLink()
    {
        return isset( $this->response['profileUrl'] ) ? $this->response['profileUrl'] : null;
    }

    /**
     * Get avatar image URL.
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->response['imageUrl'];
    }

    /**
     * Get user data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
