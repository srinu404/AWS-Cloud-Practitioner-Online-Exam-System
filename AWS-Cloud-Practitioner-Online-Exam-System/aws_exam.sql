-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 04:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aws_exam`
--
CREATE DATABASE IF NOT EXISTS `aws_exam` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aws_exam`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `is_default`) VALUES
(6, 'srinu', '$2y$10$8KhcXVCnq/7QsDmxQ85ug.FRT03lS/om/vKsJuHNcXtgWawABV9tS', '2026-02-11 17:42:18', 1),
(8, '1', '$2y$10$Gg/Njg7dbMCBFGAF9Jg0Ie7MCVMI.zPlMOYSRwXMHrIeubd7sF9Ya', '2026-02-11 18:03:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` varchar(50) DEFAULT NULL,
  `attempt_no` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `student_id`, `question_id`, `answer`, `attempt_no`) VALUES
(94, 10, 333, 'A', 1),
(95, 10, 279, 'D', 1),
(96, 10, 296, 'B', 2),
(97, 10, 294, 'D', 2),
(98, 10, 302, 'D', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_text` varchar(255) DEFAULT NULL,
  `option_value` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `option_value`) VALUES
(1085, 270, 'AWS Certificate Manager (ACM)', 'A'),
(1086, 270, 'Amazon Cognito', 'B'),
(1087, 270, 'AWS Key Management Service (AWS KMS)', 'C'),
(1088, 270, 'AWS Trusted Advisor', 'D'),
(1089, 271, 'Reserved Instances', 'A'),
(1090, 271, 'On-Demand Instances', 'B'),
(1091, 271, 'Spot Instances', 'C'),
(1092, 271, 'Dedicated Hosts', 'D'),
(1093, 272, 'Amazon GuardDuty', 'A'),
(1094, 272, 'AWS Shield', 'B'),
(1095, 272, 'AWS WAF', 'C'),
(1096, 272, 'AWS CloudTrail', 'D'),
(1097, 273, 'AWS CLI', 'A'),
(1098, 273, 'AWS CodeBuild', 'B'),
(1099, 273, 'AWS Cloud Adoption Framework (AWS CAF)', 'C'),
(1100, 273, 'AWS Systems Manager Session Manager', 'D'),
(1101, 274, 'Trade variable expenses for capital expenses', 'A'),
(1102, 274, 'Benefit from economies of scale', 'B'),
(1103, 274, 'Increase focus on managing hardware infrastructure', 'C'),
(1104, 274, 'Overprovision resources to ensure capacity', 'D'),
(1105, 275, 'Identity and access management', 'A'),
(1106, 275, 'Cloud financial management', 'B'),
(1107, 275, 'Application portfolio management', 'C'),
(1108, 275, 'Innovation management', 'D'),
(1109, 276, 'Configuring security groups and firewall rules', 'A'),
(1110, 276, 'Encrypting website data storage on Amazon EBS', 'B'),
(1111, 276, 'Maintaining the physical security of data centers', 'C'),
(1112, 276, 'Ensuring the guest OS has the latest patches', 'D'),
(1113, 277, 'Amazon S3 Outposts', 'A'),
(1114, 277, 'Amazon S3 Glacier Instant Retrieval', 'B'),
(1115, 277, 'Amazon S3 Standard', 'C'),
(1116, 277, 'Amazon S3 Intelligent-Tiering', 'D'),
(1117, 278, 'Open-source Docker orchestrator on EC2', 'A'),
(1118, 278, 'AWS AppSync', 'B'),
(1119, 278, 'Amazon Elastic Container Registry (ECR)', 'C'),
(1120, 278, 'Amazon Elastic Container Service (ECS)', 'D'),
(1121, 279, 'AWS Shield Standard', 'A'),
(1122, 279, 'AWS Shield Advanced', 'B'),
(1123, 279, 'AWS Firewall Manager', 'C'),
(1124, 279, 'AWS WAF', 'D'),
(1125, 280, 'Provision the underlying infrastructure', 'A'),
(1126, 280, 'Create IAM policies to control administrative access', 'B'),
(1127, 280, 'Install cables for hardware', 'C'),
(1128, 280, 'Install and patch the RDS operating system', 'D'),
(1129, 281, 'Amazon CloudFront', 'A'),
(1130, 281, 'Elastic Load Balancing (ELB)', 'B'),
(1131, 281, 'Amazon S3', 'C'),
(1132, 281, 'AWS Direct Connect', 'D'),
(1133, 282, 'Scale the number of EC2 instances in or out automatically', 'A'),
(1134, 282, 'Use serverless EC2 instances', 'B'),
(1135, 282, 'Scale the size of EC2 instances up or down automatically', 'C'),
(1136, 282, 'Transfer unused CPU resources', 'D'),
(1137, 283, 'On-premises to cloud native', 'A'),
(1138, 283, 'Hybrid to cloud native', 'B'),
(1139, 283, 'On-premises to hybrid', 'C'),
(1140, 283, 'Cloud native to hybrid', 'D'),
(1141, 284, 'Launch globally in minutes', 'A'),
(1142, 284, 'Increase speed and agility', 'B'),
(1143, 284, 'High economies of scale', 'C'),
(1144, 284, 'No guessing about compute capacity', 'D'),
(1145, 285, 'Create annotated documentation', 'A'),
(1146, 285, 'Anticipate failure', 'B'),
(1147, 285, 'Ensure performance efficiency', 'C'),
(1148, 285, 'Optimize costs', 'D'),
(1149, 286, 'Installing security patches', 'A'),
(1150, 286, 'Encrypting data in the database', 'B'),
(1151, 286, 'Backing up the database server', 'C'),
(1152, 286, 'Encrypting data at the application level', 'D'),
(1153, 287, 'AWS Direct Connect', 'A'),
(1154, 287, 'Amazon Connect', 'B'),
(1155, 287, 'AWS Site-to-Site VPN', 'C'),
(1156, 287, 'AWS Client VPN', 'D'),
(1157, 288, 'On-Demand Instances', 'A'),
(1158, 288, 'Reserved Instances', 'B'),
(1159, 288, 'Dedicated Instances', 'C'),
(1160, 288, 'Spot Instances', 'D'),
(1161, 289, 'Amazon DynamoDB', 'A'),
(1162, 289, 'Amazon Aurora', 'B'),
(1163, 289, 'Amazon Neptune', 'C'),
(1164, 289, 'Amazon Athena', 'D'),
(1165, 290, 'Amazon Lex', 'A'),
(1166, 290, 'AWS Amplify', 'B'),
(1167, 290, 'Amazon Comprehend', 'C'),
(1168, 290, 'Amazon Polly', 'D'),
(1169, 291, 'Amazon VPC internet gateway', 'A'),
(1170, 291, 'Amazon VPC NAT gateway', 'B'),
(1171, 291, 'Amazon VPC route tables', 'C'),
(1172, 291, 'Amazon VPC network ACL', 'D'),
(1173, 292, 'Scalability', 'A'),
(1174, 292, 'Loose coupling', 'B'),
(1175, 292, 'Automation', 'C'),
(1176, 292, 'Caching', 'D'),
(1177, 293, 'Network Load Balancer', 'A'),
(1178, 293, 'Amazon S3 Transfer Acceleration', 'B'),
(1179, 293, 'AWS Global Accelerator', 'C'),
(1180, 293, 'Application Load Balancer', 'D'),
(1181, 294, 'AWS Global Accelerator', 'A'),
(1182, 294, 'Amazon S3 Transfer Acceleration', 'B'),
(1183, 294, 'AWS Direct Connect', 'C'),
(1184, 294, 'Amazon CloudFront', 'D'),
(1185, 295, 'Amazon EventBridge', 'A'),
(1186, 295, 'AWS IAM', 'B'),
(1187, 295, 'Amazon Simple Notification Service (SNS)', 'C'),
(1188, 295, 'Amazon Connect', 'D'),
(1189, 296, 'AWS IAM', 'A'),
(1190, 296, 'Amazon Cognito', 'B'),
(1191, 296, 'AWS Directory Service', 'C'),
(1192, 296, 'AWS Organizations', 'D'),
(1193, 297, 'Compute Savings Plans', 'A'),
(1194, 297, 'EC2 Instance Savings Plans', 'B'),
(1195, 297, 'On-Demand Instances', 'C'),
(1196, 297, 'Reserved Instances', 'D'),
(1197, 298, 'Amazon Inspector', 'A'),
(1198, 298, 'Amazon Macie', 'B'),
(1199, 298, 'Amazon GuardDuty', 'C'),
(1200, 298, 'AWS Audit Manager', 'D'),
(1201, 299, 'Purchase servers for local Region', 'A'),
(1202, 299, 'Rent compute racks in colocation', 'B'),
(1203, 299, 'Deploy the application to an AWS Region', 'C'),
(1204, 299, 'Build a data center', 'D'),
(1205, 300, 'Amazon ECS', 'A'),
(1206, 300, 'AWS Snowball', 'B'),
(1207, 300, 'AWS AppSync', 'C'),
(1208, 300, 'AWS Database Migration Service (DMS)', 'D'),
(1209, 301, 'Business', 'A'),
(1210, 301, 'People', 'B'),
(1211, 301, 'Platform', 'C'),
(1212, 301, 'Operations', 'D'),
(1213, 302, 'Amazon CloudFront', 'A'),
(1214, 302, 'Availability Zone', 'B'),
(1215, 302, 'VPC', 'C'),
(1216, 302, 'AWS Outposts', 'D'),
(1217, 303, 'Supports simple coding', 'A'),
(1218, 303, 'Monitors the environment', 'B'),
(1219, 303, 'Automates threat response', 'C'),
(1220, 303, 'Model and provision resources needed', 'D'),
(1221, 304, 'Configure IAM', 'A'),
(1222, 304, 'Configure security groups', 'B'),
(1223, 304, 'Secure access of physical facilities', 'C'),
(1224, 304, 'Perform infrastructure patching', 'D'),
(1225, 305, 'Amazon CloudWatch', 'A'),
(1226, 305, 'AWS Cost Explorer', 'B'),
(1227, 305, 'AWS Pricing Calculator', 'C'),
(1228, 305, 'AWS Trusted Advisor', 'D'),
(1229, 306, 'AWS Budgets', 'A'),
(1230, 306, 'Cost Explorer', 'B'),
(1231, 306, 'Cost allocation tags', 'C'),
(1232, 306, 'Cost categories', 'D'),
(1233, 307, 'Inbound data transfer from the internet', 'A'),
(1234, 307, 'Outbound data transfer to the internet', 'B'),
(1235, 307, 'Data transfer between AWS Regions', 'C'),
(1236, 307, 'Data transfer between Availability Zones', 'D'),
(1237, 308, 'Go global in minutes', 'A'),
(1238, 308, 'Increase speed and agility', 'B'),
(1239, 308, 'Benefit from economies of scale', 'C'),
(1240, 308, 'Trade fixed expense for variable expense', 'D'),
(1241, 309, 'Rehost', 'A'),
(1242, 309, 'Replatform', 'B'),
(1243, 309, 'Refactor', 'C'),
(1244, 309, 'Repurchase', 'D'),
(1245, 310, 'Placement groups', 'A'),
(1246, 310, 'Consolidated billing', 'B'),
(1247, 310, 'Edge locations', 'C'),
(1248, 310, 'Multiple AWS accounts', 'D'),
(1249, 311, 'Deletion of IAM users', 'A'),
(1250, 311, 'Deletion of an AWS account', 'B'),
(1251, 311, 'Creation of an organization', 'C'),
(1252, 311, 'Deletion of EC2 instances', 'D'),
(1253, 312, 'Amazon Aurora', 'A'),
(1254, 312, 'VPC', 'B'),
(1255, 312, 'Amazon SageMaker', 'C'),
(1256, 312, 'AWS IAM', 'D'),
(1257, 313, 'AWS Outposts', 'A'),
(1258, 313, 'Amazon EC2', 'B'),
(1259, 313, 'AWS Lambda', 'C'),
(1260, 313, 'AWS Fargate', 'D'),
(1261, 314, 'Turn over all security to AWS', 'A'),
(1262, 314, 'Pay-as-you-go model', 'B'),
(1263, 314, 'Full control over physical infra', 'C'),
(1264, 314, 'No longer guessing capacity', 'D'),
(1265, 315, 'Security groups', 'A'),
(1266, 315, 'Network ACLs', 'B'),
(1267, 315, 'NAT gateways', 'C'),
(1268, 315, 'Route tables', 'D'),
(1269, 316, 'Free tier for first year', 'A'),
(1270, 316, 'Matches competitor pricing', 'B'),
(1271, 316, 'Aggregates usage for pay-as-you-go', 'C'),
(1272, 316, 'Access to unlimited resources', 'D'),
(1273, 317, 'Amazon Connect', 'A'),
(1274, 317, 'AWS Direct Connect', 'B'),
(1275, 317, 'AWS IAM Identity Center', 'C'),
(1276, 317, 'Amazon Polly', 'D'),
(1277, 318, 'Rightsizing', 'A'),
(1278, 318, 'Reliability', 'B'),
(1279, 318, 'Resilience', 'C'),
(1280, 318, 'Modernization', 'D'),
(1281, 319, 'Amazon DynamoDB', 'A'),
(1282, 319, 'Amazon S3', 'B'),
(1283, 319, 'Amazon EC2', 'C'),
(1284, 319, 'Amazon Aurora', 'D'),
(1285, 320, 'Security group', 'A'),
(1286, 320, 'Elastic network interface', 'B'),
(1287, 320, 'Amazon EBS', 'C'),
(1288, 320, 'Amazon Machine Image (AMI)', 'D'),
(1289, 321, 'AWS Business Support', 'A'),
(1290, 321, 'AWS Enterprise Support', 'B'),
(1291, 321, 'AWS Basic Support', 'C'),
(1292, 321, 'AWS Developer Support', 'D'),
(1293, 322, 'Define read access', 'A'),
(1294, 322, 'Encrypt user data at rest', 'B'),
(1295, 322, 'Implement client-side encryption', 'C'),
(1296, 322, 'Prevent storage of sensitive data', 'D'),
(1297, 323, 'Amazon Redshift', 'A'),
(1298, 323, 'Amazon Aurora', 'B'),
(1299, 323, 'Amazon DynamoDB', 'C'),
(1300, 323, 'Amazon S3', 'D'),
(1301, 324, 'IAM Access Analyzer', 'A'),
(1302, 324, 'AWS Artifact', 'B'),
(1303, 324, 'IAM credential report', 'C'),
(1304, 324, 'AWS Audit Manager', 'D'),
(1305, 325, 'AWS CloudTrail', 'A'),
(1306, 325, 'Amazon CloudWatch', 'B'),
(1307, 325, 'Amazon Inspector', 'C'),
(1308, 325, 'Amazon Macie', 'D'),
(1309, 326, 'Amazon EC2', 'A'),
(1310, 326, 'Amazon S3', 'B'),
(1311, 326, 'AWS CodePipeline', 'C'),
(1312, 326, 'AWS CodeBuild', 'D'),
(1313, 327, 'Amazon Cognito', 'A'),
(1314, 327, 'AWS Config', 'B'),
(1315, 327, 'Amazon GuardDuty', 'C'),
(1316, 327, 'AWS Systems Manager', 'D'),
(1317, 328, 'AWS WAF', 'A'),
(1318, 328, 'Network ACLs', 'B'),
(1319, 328, 'Security groups', 'C'),
(1320, 328, 'AWS Trusted Advisor', 'D'),
(1321, 329, 'Security', 'A'),
(1322, 329, 'Performance efficiency', 'B'),
(1323, 329, 'Operational excellence', 'C'),
(1324, 329, 'Reliability', 'D'),
(1325, 330, 'Amazon EC2 Auto Scaling', 'A'),
(1326, 330, 'Amazon EC2 Image Builder', 'B'),
(1327, 330, 'AWS Elastic Beanstalk', 'C'),
(1328, 330, 'Amazon Inspector', 'D'),
(1329, 331, 'Amazon RDS', 'A'),
(1330, 331, 'Amazon DynamoDB', 'B'),
(1331, 331, 'Amazon Redshift', 'C'),
(1332, 331, 'Amazon Aurora', 'D'),
(1333, 332, 'AWS Config', 'A'),
(1334, 332, 'AWS Firewall Manager', 'B'),
(1335, 332, 'AWS Organizations', 'C'),
(1336, 332, 'AWS Trusted Advisor', 'D'),
(1337, 333, 'Envision', 'A'),
(1338, 333, 'Align', 'B'),
(1339, 333, 'Scale', 'C'),
(1340, 333, 'Launch', 'D'),
(1341, 334, 'AWS Control Tower', 'A'),
(1342, 334, 'AWS Compute Optimizer', 'B'),
(1343, 334, 'AWS Service Catalog', 'C'),
(1344, 334, 'AWS Cloud Trail', 'D'),
(1345, 335, 'Cost savings', 'A'),
(1346, 335, 'Improved operational resilience', 'B'),
(1347, 335, 'Increased business agility', 'C'),
(1348, 335, 'Enhanced security', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `type` enum('single','multi','multiple') DEFAULT 'single',
  `correct_answer` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`, `correct_answer`) VALUES
(270, 'a company needs to encrypt data at rest in the aws cloud by using an encryption key that the company controls. which aws service should the company use to meet this requirement?', 'single', 'C'),
(271, 'a company needs to run its existing custom, nonproduction workloads in the aws cloud quickly and cost-effectively. which pricing model should the company use?', 'single', 'C'),
(272, 'a company wants to continuously monitor its aws accounts and workloads for malicious activity. the company also wants to receive findings. which aws service should the company use?', 'single', 'A'),
(273, 'a company\'s application developers need to quickly provision and manage aws services by using scripts. which aws offering should the developers use?', 'single', 'A'),
(274, 'which of the following is an advantage of cloud computing?', 'single', 'B'),
(275, 'which options are aws cloud adoption framework (aws caf) governance perspective capabilities? (select two)', 'multi', 'AB'),
(276, 'what is aws responsible for when companies use amazon ec2 to host a website?', 'single', 'C'),
(277, 'a company stores a large amount of data that auditors access only twice each year. which amazon s3 storage class offers the lowest cost?', 'single', 'B'),
(278, 'a company wants to deploy and manage a docker-based application on aws with the least amount of operational overhead. which solution meets this?', 'single', 'D'),
(279, 'a company with aws enterprise support needs to protect applications from ddos and requires 24/7 access to the aws ddos response team (drt). which service?', 'single', 'B'),
(280, 'which task is the responsibility of a company that is using amazon rds?', 'single', 'B'),
(281, 'a company needs a content delivery network that provides data to users globally with low latency and high transfer speeds. which service?', 'single', 'A'),
(282, 'which of the following is a way to use amazon ec2 auto scaling groups to scale capacity?', 'single', 'A'),
(283, 'a user is moving a workload from a local data center to an architecture distributed between the local data center and the aws cloud. which migration type?', 'single', 'C'),
(284, 'aws achieves lower pay-as-you-go pricing by aggregating usage across hundreds of thousands of users. this describes which advantage?', 'single', 'C'),
(285, 'which design principle is included in the operational excellence pillar of the aws well-architected framework?', 'single', 'B'),
(286, 'a customer wants to secure an application on amazon ec2. which responsibilities belong to the customer? (select two)', 'multi', 'AE'),
(287, 'a company needs a secure, encrypted connection between its data center and aws using the public internet. which service?', 'single', 'C'),
(288, 'a user has a stateful workload that will run on amazon ec2 for the next 3 years. what is the most cost-effective pricing model?', 'single', 'B'),
(289, 'which aws service provides a relational database management system fully compatible with mysql and postgresql?', 'single', 'B'),
(290, 'which aws service can a company use to build conversational chatbots for customer service?', 'single', 'A'),
(291, 'the company wants to make a vpc subnet public. which aws features should the company use? (select two)', 'multi', 'AC'),
(292, 'which aws design principle emphasizes the reduction of interdependencies between components?', 'single', 'B'),
(293, 'which aws service provides high availability and low latency by enabling failover across multiple aws regions?', 'single', 'C'),
(294, 'a company uploads files to s3 from different geographic locations. which solution will optimize transfer speeds?', 'single', 'B'),
(295, 'a company needs to use text messages for multi-factor authentication (mfa). which aws service should they use?', 'single', 'C'),
(296, 'which aws service enables users to authenticate and sign in using social identity providers like google or facebook?', 'single', 'B'),
(297, 'a company uses ec2, lambda, and fargate. which purchasing option will meet these requirements most cost-effectively?', 'single', 'A'),
(298, 'a company needs to identify and protect sensitive data using machine learning. which aws service?', 'single', 'B'),
(299, 'a company wants to make a web application available to users immediately. which solution meets this?', 'single', 'C'),
(300, 'a company plans to move on-premises data warehouses to aws with minimum downtime. which service?', 'single', 'D'),
(301, 'which aws caf perspective helps transform the workforce by developing technical and nontechnical skills?', 'single', 'B'),
(302, 'which option is an environment that consists of one or more data centers?', 'single', 'B'),
(303, 'how does aws cloudformation help users operate in the aws cloud?', 'single', 'D'),
(304, 'which tasks are the responsibility of aws according to the shared responsibility model? (select two)', 'multi', 'CE'),
(305, 'a company wants to review its monthly spend for ec2 and rds for the past year. which service?', 'single', 'B'),
(306, 'which service or feature will notify a team if spending exceeds a planned grant amount?', 'single', 'A'),
(307, 'which type of data transfer would result in no cost for the company?', 'single', 'A'),
(308, 'which advantage of cloud computing helps a company reduce upfront costs?', 'single', 'D'),
(309, 'a company wants to migrate a monolithic application to the aws cloud. which strategy?', 'single', 'A'),
(310, 'which features help a company migrate on-premises workloads to aws? (select two)', 'multi', 'BE'),
(311, 'which task requires a user to sign in as the aws account root user?', 'single', 'B'),
(312, 'which aws services and features are provided to all customers at no charge? (select two)', 'multi', 'BD'),
(313, 'a company controls on-premises factory equipment and needs to run applications with the least latency. which service?', 'single', 'A'),
(314, 'which of the following are advantages of moving to the aws cloud? (select two)', 'multi', 'BD'),
(315, 'which vpc component provides a layer of security at the subnet level?', 'single', 'B'),
(316, 'how can aws help users benefit from economies of scale?', 'single', 'C'),
(317, 'a company wants to migrate an on-premises contact center to a cloud solution. which aws service?', 'single', 'A'),
(318, 'which cloud concept is demonstrated by using aws cost explorer?', 'single', 'A'),
(319, 'which aws service requires the company to update and patch the guest operating system?', 'single', 'C'),
(320, 'a company needs to deploy ec2 instances from a component defining the os and pre-installed software. which feature?', 'single', 'D'),
(321, 'which support plan is recommended for business and mission-critical workloads?', 'single', 'B'),
(322, 'for a dynamodb application, which task is the responsibility of aws?', 'single', 'B'),
(323, 'which aws service can a company use to set up nosql databases?', 'single', 'C'),
(324, 'a company wants to audit its password and access key rotation details. which tool?', 'single', 'C'),
(325, 'which service identifies which user updated a security group for an application load balancer?', 'single', 'A'),
(326, 'a company wants to model, visualize, and automate its application deployment workflow. which service?', 'single', 'C'),
(327, 'which aws service supports user sign-up and authentication for mobile and web apps?', 'single', 'A'),
(328, 'a company needs to block sql injection attacks. which service provides this?', 'single', 'A'),
(329, 'which well-architected pillar represents workloads that are resilient and recover from failure quickly?', 'single', 'D'),
(330, 'which service assists with creation, testing, and management of custom amazon ec2 images?', 'single', 'B'),
(331, 'which aws service is designed for large amounts of data in a data warehouse environment?', 'single', 'C'),
(332, 'a company needs to manage hundreds of security groups in one place. which service?', 'single', 'B'),
(333, 'which phase of the cloud transformation journey includes identifying measurable business outcomes?', 'single', 'A'),
(334, 'a company wants to determine if an ebs volume configuration is efficient based on usage. which service?', 'single', 'B'),
(335, 'a company can now launch campaigns in 3 days instead of 3 weeks. which benefit?', 'single', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `result` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `attempt_no` int(11) NOT NULL DEFAULT 1,
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `time_taken` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `score`, `result`, `created_at`, `attempt_no`, `started_at`, `submitted_at`, `time_taken`) VALUES
(17, 10, 15, 'FAIL', '2026-02-12 11:38:42', 1, '2026-02-12 12:38:42', '2026-02-12 12:38:42', NULL),
(18, 10, 15, 'FAIL', '2026-02-12 11:56:16', 2, '2026-02-12 12:56:16', '2026-02-12 12:56:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `has_attempted` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `password`, `has_attempted`, `created_at`) VALUES
(10, '1', '1@gmail.com', '1', '$2y$10$H1DpI60pJ.epRjcKIVRF3.5QzDoFhErEFEDzhFfNB6HSEzaaD6uuO', 0, '2026-02-12 10:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `study_materials`
--

CREATE TABLE `study_materials` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `study_materials`
--

INSERT INTO `study_materials` (`id`, `title`, `file_name`, `uploaded_at`) VALUES
(1, 'aws', '1770891476_AWS cloud practitionary.pdf', '2026-02-12 10:17:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_answers_question` (`question_id`),
  ADD KEY `id` (`id`,`student_id`,`question_id`,`answer`),
  ADD KEY `fk_answers_student` (`student_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_question` (`question`(255));

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_results_student` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `study_materials`
--
ALTER TABLE `study_materials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1349;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `study_materials`
--
ALTER TABLE `study_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answers_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_answers_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `fk_results_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"aws_exam\",\"table\":\"questions\"},{\"db\":\"aws_exam\",\"table\":\"contact_messages\"},{\"db\":\"aws_exam\",\"table\":\"options\"},{\"db\":\"aws_exam\",\"table\":\"results\"},{\"db\":\"aws_exam\",\"table\":\"answers\"},{\"db\":\"aws_exam\",\"table\":\"students\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-02-10 12:29:16', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
