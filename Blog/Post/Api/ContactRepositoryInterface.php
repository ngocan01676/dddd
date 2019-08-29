<?php
namespace Blog\Post\Api;

interface ContactRepositoryInterface
{
	public function save(\Blog\Post\Api\Data\ContactInterface $contact);

    public function getById($Id);

    public function delete(\Blog\Post\Api\Data\ContactInterface $contact);

    public function deleteById($Id);
}
