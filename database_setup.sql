
-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE `error_log` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `time_received` datetime NOT NULL,
  `content` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo_extracts`
--

CREATE TABLE `photo_extracts` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `source_file` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `grad_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='associate partial images with people';

-- --------------------------------------------------------

--
-- Table structure for table `photo_pairs`
--

CREATE TABLE `photo_pairs` (
  `id` int(11) NOT NULL,
  `pair_filename` varchar(255) NOT NULL,
  `submission_filename` varchar(255) NOT NULL,
  `old_photo_filename` varchar(255) NOT NULL,
  `old_photo_table` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `time_received` datetime NOT NULL,
  `sender` varchar(255) NOT NULL,
  `subject` text,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yearbook_photos`
--

CREATE TABLE `yearbook_photos` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `grad_year` year(4) NOT NULL,
  `yearbook_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='yearbook photos';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `error_log`
--
ALTER TABLE `error_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo_extracts`
--
ALTER TABLE `photo_extracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo_pairs`
--
ALTER TABLE `photo_pairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yearbook_photos`
--
ALTER TABLE `yearbook_photos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `error_log`
--
ALTER TABLE `error_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photo_extracts`
--
ALTER TABLE `photo_extracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photo_pairs`
--
ALTER TABLE `photo_pairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yearbook_photos`
--
ALTER TABLE `yearbook_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

