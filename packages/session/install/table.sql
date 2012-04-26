-- The following table is required to use this session package.
CREATE TABLE `sessions` (
`session_id` varchar(255) NOT NULL,
`data` blob NOT NULL,
`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`session_id`)
);
