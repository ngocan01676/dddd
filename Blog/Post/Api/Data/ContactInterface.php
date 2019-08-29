<?php
namespace Blog\Post\Api\Data;

interface ContactInterface
{
    const CONTACT_ID = 'contact_id';
    const NAME	= 'name';
    const EMAIL	= 'email';
    const COMMENT='commnent';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT= 'creation_time';
    const UPDATED_AT= 'update_time';
    
	public function getIds();

	public function getNames();

    public function getEmails();

    public function getComments();
     public function getIs_actives();
	
    public function getCreatedAt();

    public function getUpdatedAt();
	
    public function setIds($id);
	
	public function setNames($name);
    public function setComments($commnent);
	
    public function setEmails($email);
	
    public function setIs_actives($is_actives);
	
    public function setCreatedAt($created_at);

    public function setUpdatedAt($updated_at);

}
