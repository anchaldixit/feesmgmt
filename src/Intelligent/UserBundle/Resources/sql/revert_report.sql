ALTER TABLE `role_global_permission` ADD `report_permission` TINYINT NOT NULL ;
DROP TABLE IF EXISTS `role_report_permission`;
CREATE TABLE IF NOT EXISTS `customer_allowed_reports` (
`id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `report_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_allowed_reports`
--
ALTER TABLE `customer_allowed_reports`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_allowed_reports`
--
ALTER TABLE `customer_allowed_reports`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
