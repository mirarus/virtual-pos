<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\BuyerInterface;

/**
 * Buyer
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class Buyer implements BuyerInterface
{
	private $id;
	private $name;
	private $surname;
	private $email;
	private $phone;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param $id
	 * @return void
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getSurname(): string
	{
		return $this->surname;
	}

	/**
	 * @param string $surname
	 * @return void
	 */
	public function setSurname(string $surname): void
	{
		$this->surname = $surname;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param $phone
	 * @return void
	 */
	public function setPhone($phone): void
	{
		$this->phone = $phone;
	}
}