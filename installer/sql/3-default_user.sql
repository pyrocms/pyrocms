TRUNCATE `users`;

-- command split --

INSERT INTO `users` (`id`, `email`, `password`, `salt`, `group_id`, `ip_address`, `active`, `activation_code`, `created_on`, `last_login`, `username`, `forgotten_password_code`, `remember_code`) VALUES
(1,'__EMAIL__', '__PASSWORD__', '__SALT__', 1, '', 1, '', __NOW__, __NOW__, '__USERNAME__', NULL, NULL);

-- command split --

TRUNCATE `profiles`;

-- command split --

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `company`, `lang`, `bio`, `dob`, `gender`, `phone`, `mobile`, `address_line1`, `address_line2`, `address_line3`, `postcode`, `msn_handle`, `yim_handle`, `aim_handle`, `gtalk_handle`, `gravatar`, `updated_on`) VALUES
(1, 1, '__FIRSTNAME__', '__LASTNAME__', '', 'en', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
