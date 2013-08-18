说明
=======
* pdo.php      : db配置文件
* City.php     : 城市Class, 功能实现文件
* task1.sql    : 数据库结构
* CityTest.php : PHPUnit测试脚本，所有task1中的相关功能均有test case.

为什么不做后2部分
=======
* 这几部分有点像策划给出和策划案，我比较习惯有些不清楚的问题可以直接和策划讨论。比如：
    * 第一部分的金币和税率，文档中只说初始没有金子，税率是20％。请问金子的来源是什么，20%是based on什么基数和时间长度？
    * 税率是指什么，是玩家城市产生金子的来源还是系统从玩家手中抽取的数量？
    * 后两部分有基于金子的内容，我不喜欢做假设。
* 第1部分的大概框架已经有了，后2部分从本质上说和第一部分没有什么区别，不过是功能和代码还有业务逻辑的堆砌，个人无法从中看出这3部分可以区分出中、高、初级程序员。
* 这部分代码是单纯的业务逻辑，不具备重用性和思维训练功能，个人认为比较浪费时间。
