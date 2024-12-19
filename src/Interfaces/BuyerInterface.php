<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * BuyerInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface BuyerInterface
{
	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @param $id
	 * @return void
	 */
	public function setId($id): void;

	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName(string $name): void;

	/**
	 * @return string
	 */
	public function getSurname(): string;

	/**
	 * @param string $surname
	 * @return void
	 */
	public function setSurname(string $surname): void;

	/**
	 * @return string
	 */
	public function getFullName(): string;

	/**
	 * @return string
	 */
	public function getEmail(): string;

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail(string $email): void;

	/**
	 * @return mixed
	 */
	public function getPhone();

	/**
	 * @param $phone
	 * @return void
	 */
	public function setPhone($phone): void;


	/**
	 * @return mixed
	 */
	public function getIdentityNumber();

	/**
	 * @param mixed $identityNumber
	 */
	public function setIdentityNumber($identityNumber): void;
}