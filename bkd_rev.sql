-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2014 at 07:31 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bkd_rev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `uname` varchar(7) NOT NULL,
  `pass` char(7) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`uname`, `pass`, `date`) VALUES
('andrian', 'andrian', '2014-03-05 04:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_form_skp`
--

CREATE TABLE IF NOT EXISTS `tbl_form_skp` (
  `tahun_skp` int(4) NOT NULL,
  `penilai` char(21) NOT NULL,
  `dinilai` char(21) NOT NULL,
  `tugas` varchar(50) NOT NULL,
  `kredit` int(3) NOT NULL,
  `kredit_real` int(3) NOT NULL,
  `kuantitas` int(4) NOT NULL,
  `kuantitas_real` int(4) NOT NULL,
  `kualitas` int(4) NOT NULL,
  `kualitas_real` int(4) NOT NULL,
  `waktu` int(2) NOT NULL,
  `waktu_real` int(2) NOT NULL,
  `biaya` int(6) NOT NULL,
  `biaya_real` int(6) NOT NULL,
  `penghitungan` int(11) NOT NULL,
  `nilai_capaian_skp` decimal(4,2) NOT NULL,
  `nilai_skp` decimal(3,2) NOT NULL,
  `tgl_form` date NOT NULL,
  `tgl_penilaian_skp` date NOT NULL,
  `time` varchar(10) NOT NULL,
  KEY `penilai` (`penilai`),
  KEY `dinilai` (`dinilai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_form_skp`
--

INSERT INTO `tbl_form_skp` (`tahun_skp`, `penilai`, `dinilai`, `tugas`, `kredit`, `kredit_real`, `kuantitas`, `kuantitas_real`, `kualitas`, `kualitas_real`, `waktu`, `waktu_real`, `biaya`, `biaya_real`, `penghitungan`, `nilai_capaian_skp`, `nilai_skp`, `tgl_form`, `tgl_penilaian_skp`, `time`) VALUES
(2014, '196312111989031017', '197411222008011004', 'Tugas ini adalah wajib', 0, 0, 12, 10, 100, 95, 12, 12, 0, 0, 254, 84.80, 0.00, '0000-00-00', '0000-00-00', '09:49:43'),
(2014, '196312111989031017', '197411222008011004', 'bismillah', 0, 0, 5000, 5000, 100, 85, 12, 12, 0, 0, 261, 87.00, 0.00, '0000-00-00', '0000-00-00', '10:04:52'),
(2014, '196312111989031017', '196609232006041003', 'dfavfdsava', 2, 0, 5000, 0, 100, 0, 5, 0, 200000, 0, 0, 0.00, 0.00, '0000-00-00', '0000-00-00', '13:54:36'),
(2014, '196312111989031017', '196609232006041003', 'dsfabfda', 2, 0, 5000, 0, 100, 0, 11, 0, 200000, 0, 0, 0.00, 0.00, '0000-00-00', '0000-00-00', '13:54:59'),
(2014, '196312111989031017', '196609232006041003', 'dsadafgsa', 2, 0, 5000, 0, 100, 0, 3, 0, 200000, 0, 0, 0.00, 0.00, '0000-00-00', '0000-00-00', '13:55:36'),
(2014, '196312111989031017', '196108282007011007', 'dagfsagdfa', 2, 2, 5000, 5000, 100, 10, 11, 11, 200000, 150000, 287, 71.75, 0.00, '0000-00-00', '0000-00-00', '13:55:56'),
(2014, '196312111989031017', '197209152007012014', 'tugassss', 0, 0, 12, 12, 100, 89, 12, 0, 4000, 0, 541, 99.99, 0.00, '0000-00-00', '0000-00-00', '00:11:58'),
(2014, '196312111989031017', '196108282007011007', 'tugas', 0, 0, 100, 100, 100, 100, 12, 6, 0, 0, 326, 99.99, 0.00, '0000-00-00', '0000-00-00', '00:19:07'),
(2014, '197206051994031007', '197305202006041023', 'gagfsdagfsa', 0, 0, 12, 12, 100, 100, 9, 9, 0, 0, 276, 92.00, 0.00, '0000-00-00', '0000-00-00', '19:05:27'),
(2014, '196312111989031017', '197803192009011001', 'dfsafdsa', 0, 0, 12, 12, 100, 100, 10, 12, 0, 0, 256, 85.33, 0.00, '0000-00-00', '0000-00-00', '19:14:48'),
(2014, '196312111989031017', '133214244545454545', 'aaaaaaaaaaaaaaaaaaaaaaa', 0, 0, 1000, 999, 98, 99, 9, 12, 100000, 200000, 220, 54.90, 0.00, '0000-00-00', '0000-00-00', '17:44:47'),
(2015, '196312111989031017', '197209152007012014', 'dsagfdsa', 0, 0, 11, 0, 100, 0, 10, 0, 0, 0, 176, 99.99, 0.00, '0000-00-00', '0000-00-00', '18:16:13'),
(0, '196312111989031017', '197209152007012014', 'coba', 0, 0, 1, 0, 100, 0, 5, 0, 123000, 0, 352, 99.99, 0.00, '0000-00-00', '0000-00-00', '11:12:50'),
(2014, '196312111989031017', '197209152007012014', 'dsfadsa', 0, 0, 1, 0, 100, 0, 4, 0, 100000, 0, 352, 99.99, 0.00, '0000-00-00', '0000-00-00', '11:13:37'),
(2014, '196312111989031017', '197411222008011004', 'Makalah', 0, 0, 2, 0, 100, 0, 7, 0, 100000, 0, 352, 99.99, 0.00, '0000-00-00', '0000-00-00', '11:25:09'),
(2014, '196312111989031017', '197411222008011004', 'Makalah 2', 0, 0, 12, 10, 100, 90, 12, 11, 0, 0, 258, 85.89, 0.00, '0000-00-00', '0000-00-00', '11:46:45'),
(2014, '196103241985031007', '197901051999032002', 'tugazzzzzzzzzzzzzzzzz', 0, 0, 12, 0, 100, 0, 5, 0, 100000, 0, 0, 0.00, 0.00, '0000-00-00', '0000-00-00', '13:05:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE IF NOT EXISTS `tbl_jabatan` (
  `id_jabatan` int(2) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(70) NOT NULL,
  `kode` char(10) NOT NULL,
  `kode2` char(10) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id_jabatan`, `nama_jabatan`, `kode`, `kode2`) VALUES
(1, 'Kepala Badan Kepegawaian Daerah', 'kabkd', 'kabkd'),
(2, 'Kepala Bidang Umum Kepegawaian', 'kabidum', 'kabidum'),
(3, 'Kepala Bidang Pendidikan dan Pelatihan', 'kabidik', 'kabidik'),
(4, 'Kepala Bidang Mutasi Pegawai', 'kabisi', 'kabisi'),
(5, 'Kepala Bidang Perencanaan dan Pengembangan', 'kabidan', 'kabidan'),
(6, 'Kepala Sub Bidang Pengolahan Data dan Informasi', 'kasudat', 'kabidan'),
(7, 'Kepala Sub Bagian Keuangan', 'kasuang', 'sekretaris'),
(8, 'Kepala Sub Bagian Program', 'kasuprog', 'sekretaris'),
(9, 'Kepala Sub Bidang Pelayanan Administrasi dan Kesejahteraan Pegawai', 'kasulay', 'kabidum'),
(10, 'Kepala Sub Bidang Pengangkatan dan Kepangkatan', 'kasupang', 'kabisi'),
(11, 'Kepala Sub Bidang Formasi dan Jabatan', 'kasujab', 'kabidan'),
(12, 'Kepala Sub Bidang Pembinaan Disiplin dan Peraturan Perundang-Undangan', 'kasudis', 'kabidum'),
(13, 'Kepala Sub Bagian Umum', 'kasum', 'sekretaris'),
(14, 'Kepala Sub Bidang Pemindahan Pemberhentian dan Pensiun', 'kasudah', 'kabisi'),
(15, 'Kepala Sub Bidang Pendidikan dan Pelatihan Struktural', 'kasustruk', 'kabidik'),
(16, 'Kepala Sub Bidang Pendidikan dan Pelatihan Teknik Fungsional', 'kasufung', 'kabidik'),
(17, 'Kelompok Jabatan Fungsional', '', ''),
(18, 'Staf Sub Bidang Pengolahan Data dan Informasi', 'kasudat', 'kabidan'),
(19, 'Staf Sub Bagian Keuangan', 'kasuang', 'sekretaris'),
(20, 'Staf Sub Bagian Program', 'kasuprog', 'sekretaris'),
(21, 'Staf Sub Bidang Pelayanan Administrasi dan Kesejahteraan Pegawai', 'kasulay', 'kabidum'),
(22, 'Staf Sub Bidang Pengangkatan dan Kepangkatan', 'kasupang', 'kabisi'),
(23, 'Staf Sub Bidang Formasi dan Jabatan', 'kasujab', 'kabidan'),
(24, 'Staf Sub Bidang Pembinaan Disiplin dan Peraturan Perundang-Undangan', 'kasudis', 'kabidum'),
(25, 'Staf Sub Bagian Umum', 'kasum', 'sekretaris'),
(26, 'Staf Sub Bidang Pemindahan Pemberhentian dan Pensiun', 'kasudah', 'kabisi'),
(27, 'Staf Sub Bidang Pendidikan dan Pelatihan Struktural', 'kasustruk', 'kabidik'),
(28, 'Staf Sub Bidang Pendidikan dan Pelatihan Teknik Fungsional', 'kasufung', 'kabidik'),
(29, 'Sekretaris Badan Kepegawaian Daerah', 'sekretaris', 'sekretaris');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pangkat_golru`
--

CREATE TABLE IF NOT EXISTS `tbl_pangkat_golru` (
  `id_palru` int(2) NOT NULL AUTO_INCREMENT,
  `nama_palru` varchar(70) NOT NULL,
  PRIMARY KEY (`id_palru`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_pangkat_golru`
--

INSERT INTO `tbl_pangkat_golru` (`id_palru`, `nama_palru`) VALUES
(1, 'Pembina Utama, IV/e'),
(2, 'Pembina Utama Madya, IV/d'),
(3, 'Pembina Utama Muda, IV/c'),
(4, 'Pembina Tingkat I, IV/b'),
(5, 'Pembina, IV/a'),
(6, 'Penata Tingkat I, III/d'),
(7, 'Penata, III/c'),
(8, 'Penata Muda Tingkat I, III/b'),
(9, 'Penata Muda, III/a'),
(10, 'Pengatur Tingkat I, II/d'),
(11, 'Pengatur, II/c'),
(12, 'Pengatur Muda Tingat I, II/b'),
(13, 'Pengatur Muda, II/a'),
(14, 'Juru Tingat I, I/d'),
(15, 'Juru, I/c'),
(16, 'Juru Muda Tingkat I, I/b'),
(17, 'Juru Muda, I/a'),
(18, '-');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pkp`
--

CREATE TABLE IF NOT EXISTS `tbl_pkp` (
  `tahun_pkp` int(4) NOT NULL,
  `penilai` char(21) NOT NULL,
  `dinilai` char(21) NOT NULL,
  `atasan_penilai` char(21) NOT NULL,
  `orientasi_pelayanan` int(3) NOT NULL,
  `integritas` int(3) NOT NULL,
  `komitmen` int(3) NOT NULL,
  `disiplin` int(3) NOT NULL,
  `kerjasama` int(3) NOT NULL,
  `kepemimpinan` int(3) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `nilai_rata` decimal(4,2) NOT NULL,
  `nilai_pkp` decimal(4,2) NOT NULL,
  `tanggapan` varchar(50) NOT NULL,
  `keputusan` varchar(50) NOT NULL,
  `rekomendasi` varchar(50) NOT NULL,
  `tgl_penilaian_pkp` date NOT NULL,
  KEY `penilai` (`penilai`),
  KEY `dinilai` (`dinilai`),
  KEY `tbl_pkp_ibfk_3` (`atasan_penilai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pkp`
--

INSERT INTO `tbl_pkp` (`tahun_pkp`, `penilai`, `dinilai`, `atasan_penilai`, `orientasi_pelayanan`, `integritas`, `komitmen`, `disiplin`, `kerjasama`, `kepemimpinan`, `jumlah`, `nilai_rata`, `nilai_pkp`, `tanggapan`, `keputusan`, `rekomendasi`, `tgl_penilaian_pkp`) VALUES
(2014, '196312111989031017', '197411222008011004', '196103241985031007', 100, 100, 100, 100, 100, 100, 600, 99.99, 40.00, '', '', '', '2014-04-02'),
(2014, '196312111989031017', '197209152007012014', '196103241985031007', 50, 50, 50, 50, 60, 80, 340, 56.67, 22.67, 'avfdsavdfsa', 'vdsavbfesbytmuyt', 'mgfnsgarfgvfdsav', '2014-03-11'),
(2014, '196312111989031017', '196108282007011007', '196103241985031007', 80, 90, 90, 90, 90, 91, 531, 88.50, 35.40, 'GASFDGASGDFSAD', 'dsadvsavasdv', 'sadvsadvsdvsa', '2014-03-06'),
(2014, '196312111989031017', '133214244545454545', '196103241985031007', 10, 10, 10, 10, 100, 10, 150, 25.00, 10.00, 'aaaaaaaaaaaaaa', 'bbbbbbbbbbbbbbbb', 'ccccccccccccccc', '2014-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pns`
--

CREATE TABLE IF NOT EXISTS `tbl_pns` (
  `nip` char(21) NOT NULL,
  `nama_pns` varchar(40) NOT NULL,
  `jekel` enum('Laki-laki','Perempuan') NOT NULL,
  `id_palru` int(2) DEFAULT NULL,
  `id_jabatan` int(2) DEFAULT NULL,
  `tmt` date NOT NULL,
  `unit_kerja` varchar(70) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `level` varchar(10) NOT NULL,
  PRIMARY KEY (`nip`),
  KEY `id_palru` (`id_palru`),
  KEY `id_jabatan` (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pns`
--

INSERT INTO `tbl_pns` (`nip`, `nama_pns`, `jekel`, `id_palru`, `id_jabatan`, `tmt`, `unit_kerja`, `pwd`, `level`) VALUES
('133214244545454545', 'yona', 'Laki-laki', 5, 25, '2014-05-01', 'uhjhk', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('195710121977101001', 'Suwignyo', 'Laki-laki', 18, 1, '1977-10-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196011271985121003', 'Eko Supriyatno', 'Laki-laki', 8, 23, '2007-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196012312006041469', 'Suparmin', 'Laki-laki', 18, 25, '2013-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196103241985031007', 'Joko Ristriyono', 'Laki-laki', 5, 29, '2011-04-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196104242006041003', 'Sucahyo Panilih', 'Laki-laki', 18, 25, '2013-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196108282007011007', 'Wartoyo', 'Laki-laki', 18, 25, '2013-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196208111986031019', 'Catur Agus Irianto', 'Laki-laki', 18, 3, '2013-10-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196306261986071001', 'Suprayogi', 'Laki-laki', 6, 5, '2008-10-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196307271994032002', 'Erna Yuliani', 'Perempuan', 6, 4, '2006-04-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196312101990032003', 'Endang Suci Maryanti', 'Perempuan', 8, 28, '2010-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196312111989031017', 'Muhith', 'Laki-laki', 7, 13, '2012-10-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('196501301986032002', 'Betti Astuti', 'Perempuan', 6, 9, '2011-10-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('196606281993032004', 'Sri Suwartiningsih', 'Perempuan', 6, 6, '2005-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('196609232006041003', 'Sumartono', 'Laki-laki', 15, 25, '2006-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196708051988031008', 'Rukun Pujo Santoso', 'Laki-laki', 18, 2, '2010-10-01', '', '20e26eda0c2128ca7203f6f0e439b79b', 'atasan'),
('196708051994011003', 'Bambang Setya Kunanto', 'Laki-laki', 7, 10, '2010-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('196708181987031005', 'Rustam', 'Laki-laki', 8, 14, '2006-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('196806031992031009', 'Arif Chusaini', 'Laki-laki', 18, 28, '2012-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('196904121999032004', 'Sri Prasetyowati', 'Perempuan', 6, 7, '2011-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('197007071990032001', 'Yuli Dewi Ratih', 'Perempuan', 12, 14, '1994-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('197112011992031002', 'Dijan Wahjudi', 'Laki-laki', 8, 27, '2011-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197206051994031007', 'Kristiawan Sri Hadi', 'Laki-laki', 7, 12, '2010-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('197209152007012014', 'Sri Hesti Trianiasari', 'Perempuan', 12, 25, '2011-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197305202006041023', 'Muhamad Muniri', 'Laki-laki', 8, 24, '2010-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197411222008011004', 'Mohamad Zuhri', 'Laki-laki', 4, 25, '2012-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197705252011011004', 'Arif Budiyanto', 'Laki-laki', 9, 18, '2011-01-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197803192009011001', 'Honi Sugiharto', 'Laki-laki', 14, 25, '2013-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197804152006042023', 'Puji Rahayu', 'Perempuan', 8, 12, '2010-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('197809212006042009', 'Ida Nurhayati', 'Perempuan', 18, 25, '2013-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197901051999032002', 'Siti Khusnun Nisa', 'Perempuan', 9, 19, '2010-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('197905132005012005', 'Anggya Agung Karuniastuti', 'Perempuan', 8, 15, '2009-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('198004291999122001', 'Ani Wahyu Kumalasari', 'Perempuan', 7, 11, '2010-04-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('198111302006041004', 'Hamid Rochim', 'Laki-laki', 12, 23, '2010-04-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198303262002121001', 'Hananto Adhi Nugroho', 'Laki-laki', 8, 22, '2010-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198304082010011020', 'Antonius Indrawan Sulistiyono', 'Laki-laki', 6, 18, '2013-10-28', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198311122009032011', 'Sri Jaya Mulyati', 'Perempuan', 11, 19, '2011-01-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198503172005012003', 'Shinta Wahyu Pamungkas', 'Perempuan', 11, 21, '2009-10-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198512292010011016', 'M. Aminudin', 'Laki-laki', 9, 20, '2010-01-01', '', '5525f75d130f2802430c6651a613f0b5', 'pegawai'),
('198809092011011006', 'Galuh Candra Purnama', 'Laki-laki', 11, 14, '2011-01-01', '', '5b0e90651249ec2a25546cd8489c1fa1', 'penilai'),
('aldy', '', '', NULL, NULL, '0000-00-00', '', 'c53c778a09fe1676e50ce6b0b26b6952', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rewpun`
--

CREATE TABLE IF NOT EXISTS `tbl_rewpun` (
  `id_rewpun` int(2) NOT NULL AUTO_INCREMENT,
  `jenis_rewpun` varchar(30) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  PRIMARY KEY (`id_rewpun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_form_skp`
--
ALTER TABLE `tbl_form_skp`
  ADD CONSTRAINT `tbl_form_skp_ibfk_1` FOREIGN KEY (`penilai`) REFERENCES `tbl_pns` (`nip`),
  ADD CONSTRAINT `tbl_form_skp_ibfk_2` FOREIGN KEY (`dinilai`) REFERENCES `tbl_pns` (`nip`);

--
-- Constraints for table `tbl_pkp`
--
ALTER TABLE `tbl_pkp`
  ADD CONSTRAINT `tbl_pkp_ibfk_1` FOREIGN KEY (`penilai`) REFERENCES `tbl_pns` (`nip`),
  ADD CONSTRAINT `tbl_pkp_ibfk_2` FOREIGN KEY (`dinilai`) REFERENCES `tbl_pns` (`nip`),
  ADD CONSTRAINT `tbl_pkp_ibfk_3` FOREIGN KEY (`atasan_penilai`) REFERENCES `tbl_pns` (`nip`);

--
-- Constraints for table `tbl_pns`
--
ALTER TABLE `tbl_pns`
  ADD CONSTRAINT `tbl_pns_ibfk_1` FOREIGN KEY (`id_palru`) REFERENCES `tbl_pangkat_golru` (`id_palru`),
  ADD CONSTRAINT `tbl_pns_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
