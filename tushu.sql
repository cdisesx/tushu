/*
Navicat MySQL Data Transfer

Source Server         : tushu
Source Server Version : 50533
Source Host           : tushu:3306
Source Database       : tushu

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2017-02-14 15:15:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '书籍名称',
  `introduction` text COMMENT '书籍简介',
  `pic` varchar(100) DEFAULT NULL COMMENT '照片',
  `status` tinyint(4) DEFAULT '1' COMMENT '借阅状态：1-在架 2-已借出 3-丢失',
  `user_id` int(11) DEFAULT NULL COMMENT '借阅人id',
  `borrow_time` datetime DEFAULT NULL COMMENT '借阅时间',
  `buy_time` datetime DEFAULT NULL COMMENT '入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('1', 'web安全测试', '《Web安全测试》内容简介：在你对Web应用所执行的测试中，安全测试可能是最重要的，但它却常常是最容易被忽略的。《Web安全测试》中的秘诀演示了开发和测试人员在进行单元测试、回归测试或探索性测试的同时，如何去检查最常见的Web安全问题。与即兴的安全评估不同的是，这些秘诀是可重复的、简洁的、系统的——可以完美地集成到你的常规测试套装中。\r\n《Web安全测试》中的秘诀所覆盖的基础知识包括了从观察客户端和服务器之间的消息到使用脚本完成登录并执行Web应用功能的多阶段测试。在《Web安全测试》的最后，你将能够建立精确定位到Ajax函数的测试，以及适用于常见怀疑对象（跨站式脚本和注入攻击）的大型多级测试。', '/face/websafe.jpg', '2', '13', '2017-02-14 10:22:40', '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('2', 'React Native入门与实战', '本书共4部分，首先简要介绍了React Native的开发基础知识，然后介绍了React Native的API、组件以及Native扩展和组件的封装，接着介绍了App的动态更新和上架过程，最后通过3个案例介绍了如何使用React Native开发原生App。本书适合想使用React Native开发原生应用的人阅读。', '/face/reactnative.jpg', '1', '0', '2017-02-14 10:06:01', '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('3', 'Redis实战', '本书深入浅出地介绍了Redis的5种数据类型，并通过多个实用示例展示了Redis的用法。除此之外，书中还讲述了Redis的优化方法以及扩展方法，是一本对于学习和使用 Redis 来说不可多得的参考书籍。\r\n本书一共由三个部分组成。首部分对Redis进行了介绍，说明了Redis的基本使用方法、它拥有的5种数据结构以及操作这5种数据结构的命令，并讲解了如何使用Redis去构建文章展示网站、cookie、购物车、网页缓存、数据库行缓存等一系列程序。第二部分对Redis命令进行了更详细的介绍，并展示了如何使用Redis去构建更为复杂的辅助工具和应用程序，并在结尾展示了如何使用Redis去构建一个简单的社交网站。第三部分对Redis用户经常会遇到的一些问题进行了介绍，讲解了降低Redis内存占用的方法、扩展Redis性能的方法以及使用Lua语言进行脚本编程的方法。', '/face/redis.jpg', '1', '0', '2017-02-14 10:07:35', '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('4', '美国纽约摄影学院摄影教材(最新修订版)(套装上下册)', '《美国纽约摄影学院摄影教材(最新修订版)(套装上下册)》内容简介：一本经久实用的教材总是引导我们去把握摄影作晶与影像之外的时空所形成的各种相互冲突和相互生成的关系，从而使得视觉的权力越来越具有主体性。这本实际而通俗的摄影入门书，很好地解答了我对于摄影技术的疑惑，它会让你成为优秀的摄影匠，如果你继续深入阅读与实践，最终会成为优秀的摄影家。', '/face/meiguo.jpg', '1', '0', null, '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('5', '价值主张设计:如何构建商业模式最重要的环节', '这本书的基本理念与《商业模式新生代》一致，但更聚焦于商业模式设计最核心的部分——价值主张设计。任何成功的商业模式都是基于伟大的价值主张的嵌入。\r\n本书聚焦于最小的代价做出最 好的创新；聚焦于支付较少的费用获得巨大的用户数量；聚焦于用户是怎么来衡量产品的成功；聚焦于最高价值的工作、最有效的服务、最能获得收益的事；聚焦于通过价值主张画布设计、测试、创建和管理客户真正想要的产品和服务。', '/face/jiazhi.jpg', '1', '0', null, '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('6', 'SRE:Google运维解密', '大型软件系统生命周期的绝大部分都处于“使用”阶段，而非“设计”或“实现”阶段。那么为什么我们却总是认为软件工程应该首要关注设计和实现呢？在本书中，Google SRE的关键成员解释了他们是如何对软件进行生命周期的整体性关注的，以及为什么这样做能够帮助Google成功地构建、部署、监控和运维世界上现存很大的软件系统。通过阅读本书，读者可以学习到Google工程师在提高系统部署规模、改进可靠性和资源利用效率方面的指导思想与具体实践——这些都是可以立即直接应用的宝贵经验。任何一个想要创建、扩展大规模集成系统的人都应该阅读本书。本书针对如何构建一个可长期维护的系统提供了非常宝贵的实践经验。\r\n\r\n《SRE：Google运维解密》内容提要\r\n大型软件系统生命周期的绝大部分都处于“使用”阶段，而非“设计”或“实现”阶段。那么为什么我们却总是认为软件工程应该首要关注设计和实现呢？在《SRE：Google运维解密》中，Google SRE的关键成员解释了他们是如何对软件进行生命周期的整体性关注的，以及为什么这样做能够帮助Google成功地构建、部署、监控和运维世界上现存很大的软件系统。通过阅读《SRE：Google运维解密》，读者可以学习到Google工程师在提高系统部署规模、改进可靠性和资源利用效率方面的指导思想与具体实践——这些都是可以立即直接应用的宝贵经验。\r\n任何一个想要创建、扩展大规模集成系统的人都应该阅读《SRE：Google运维解密》。《SRE：Google运维解密》针对如何构建一个可长期维护的系统提供了非常宝贵的实践经验。\r\n\r\n\r\n大型软件系统生命周期的绝大部分都处于“使用”阶段，而非“设计”或“实现”阶段。那么为什么我们却总是认为软件工程应该首要关注设计和实现呢？在本书中，Google SRE的关键成员解释了他们是如何对软件进行生命周期的整体性关注的，以及为什么这样做能够帮助Google成功地构建、部署、监控和运维世界上现存最大的软件系统。通过阅读本书，读者可以学习到Google工程师在提高系统部署规模、改进可靠性和资源利用效率方面的指导思想与具体实践——这些都是可以立即直接应用的宝贵经验。任何一个想要创建、扩展大规模集成系统的人都应该阅读本书。本书针对如何构建一个可长期维护的系统提供了非常宝贵的实践经验。', '/face/sre.jpg', '1', '0', null, '2016-12-15 14:04:30');
INSERT INTO `book` VALUES ('7', '从Paxos到Zookeeper:分布式一致性原理与实践', '《从Paxos到Zookeeper：分布式一致性原理与实践》内容提要\r\n《Paxos到Zookeeper：分布式一致性原理与实践》从分布式一致性的理论出发，向读者简要介绍几种典型的分布式一致性协议，以及解决分布式一致性问题的思路，其中重点讲解了Paxos和ZAB协议。同时，《Paxos到Zookeeper：分布式一致性原理与实践》深入介绍了分布式一致性问题的工业解决方案——ZooKeeper，并着重向读者展示这一分布式协调框架的使用方法、内部实现及运维技巧，旨在帮助读者全面了解ZooKeeper，并更好地使用和运维ZooKeeper。全书共8章，分为五部分：一部分（第1章）主要介绍了计算机系统从集中式向分布式系统演变过程中面临的挑战，并简要介绍了ACID、CAP和BASE等经典分布式理论；二部分（第2～4章）介绍了2PC、3PC和Paxos三种分布式一致性协议，并着重讲解了ZooKeeper中使用的一致性协议——ZAB协议；三部分（第5～6章）介绍了ZooKeeper的使用方法，包括客户端API的使用以及对ZooKeeper服务的部署与运行，并结合真实的分布式应用场景，总结了ZooKeeper使用的实践；四部分（第7章）对ZooKeeper的架构设计和实现原理进行了深入分析，包含系统模型、Leader选举、客户端与服务端的工作原理、请求处理，以及服务器角色的工作流程和数据存储等；第五部分（第8章）介绍了ZooKeeper的运维实践，包括配置详解和监控管理等，重点讲解了如何构建一个高可用的ZooKeeper服务。', '/face/paxos.jpg', '2', '2', null, '2016-12-15 14:04:30');

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `send_time` datetime DEFAULT NULL COMMENT '生效时间',
  `num` tinyint(4) DEFAULT NULL COMMENT '发送次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='验证码';

-- ----------------------------
-- Records of code
-- ----------------------------
INSERT INTO `code` VALUES ('1', '123', '1111', '2017-02-14 13:30:53', '1');
INSERT INTO `code` VALUES ('2', '15980002220', '5324', '2017-02-14 14:27:21', '10');

-- ----------------------------
-- Table structure for history
-- ----------------------------
DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '书籍id',
  `user_id` int(11) DEFAULT NULL COMMENT '借阅者id',
  `do_type` tinyint(4) DEFAULT NULL COMMENT '执行类型：1-借阅 2-还书 3-报失',
  `do_time` datetime DEFAULT NULL COMMENT '执行时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of history
-- ----------------------------
INSERT INTO `history` VALUES ('1', '1', null, '2', '2017-02-13 18:11:37');
INSERT INTO `history` VALUES ('2', '1', '13', '1', '2017-02-13 18:13:06');
INSERT INTO `history` VALUES ('3', '1', null, '2', '2017-02-13 18:13:24');
INSERT INTO `history` VALUES ('4', '1', null, '2', '2017-02-13 18:14:19');
INSERT INTO `history` VALUES ('5', '1', null, '2', '2017-02-13 18:16:04');
INSERT INTO `history` VALUES ('6', '1', null, '3', '2017-02-13 18:20:32');
INSERT INTO `history` VALUES ('7', '1', null, '3', '2017-02-13 18:21:16');
INSERT INTO `history` VALUES ('8', '2', '15', '1', '2017-02-14 10:06:01');
INSERT INTO `history` VALUES ('9', '3', '16', '1', '2017-02-14 10:07:35');
INSERT INTO `history` VALUES ('10', '1', '13', '1', '2017-02-14 10:22:40');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(30) DEFAULT NULL COMMENT '电话',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '郭凤容', '11111111111');
INSERT INTO `user` VALUES ('2', '屠森', '22222222222');
INSERT INTO `user` VALUES ('3', '张汉镇', '33333333333');
INSERT INTO `user` VALUES ('4', '谢海滨', '44444444444');
INSERT INTO `user` VALUES ('5', '廖智明', '55555555555');
INSERT INTO `user` VALUES ('6', '123', '123');
INSERT INTO `user` VALUES ('13', '小副', '15980002220');
INSERT INTO `user` VALUES ('14', '124', '15980002220');
INSERT INTO `user` VALUES ('15', '小小福', '18662882242');
INSERT INTO `user` VALUES ('16', 'g g g g g', '111111111111');
