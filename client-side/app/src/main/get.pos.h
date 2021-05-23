/*
======================================
Подключение геоданных к серверу jarvis
через протокол thcp с tcp: 12095 и
хост thcp://jarvis.com

https://jarvis.studio/
© 2018 Teslasoft all rights reserved

Licence: https://www.jarvis.studio/term/
======================================
*/

//Генерируем файлы cookie для текущего запроса

$_SESSION_SET

$_SESSION_START

//Создаем модуль get.pos.h

function $GET_POS_H() {
	create.module ("get.pos.h");
	get.Current.Position() {
		//Разрешение на использование месторасположения
	}
	
	/*
	==================================================
	Создоем новый регион и добавляем в него
	точки "pos 1", "pos 2", "spawn", "home", "myhome"
	и задаем им значение
	==================================================
	*/
	
	var new.region();
	var region.value(#592368);
	var set.current.date = set.pos ("1.0") {

		var 2 = get.position "/cgb.jarvis.studio/files/pos.2.h" value("2");
		var 1 = get.position "/cgb.jarvis.studio/files/pos.1.h" value("1");
		var %5 = get.position "/cgb.jarvis.studio/files/pos.spawn.h" value("spawn");
		var %1 = get.position "/cgb.jarvis.studio/files/pos.home.h" value("home");
		var %2 = get.position "/cgb.jarvis.studio/files/pos.myhome.h" value("myhome");
		var +l = set.position "/cgb.jarvis.studio/files/ndx.N.h" value("N");
		var +d = set.position "/cgb.jarvis.studio/files/ndx.E.h" value("E");
		var -l = set.position "/cgb.jarvis.studio/files/ndx.S.h" value("S");
		var -d = set.position "/cgb.jarvis.studio/files/ndx.W.h" value("W");
		var pos = add.pos = "/cgb.jarvis.studio/files/err.null.h" value("null");
		var pos_1 = add.pos = "/cgb.jarvis.studio/files/con.1.1.0.h" value("1.0");
		var pos_2 = add.pos = "/cgb.jarvis.studio/files/con.2.1.0.h" value("1.0");
		var region_1 = pos [1] + pos_2_value = "stech" ();
		var region_2 = pos [1] + pos_2_value = "stech" ();
		var time = common.get.time value = "current time" set.time [hours, [minutes, [seconds, [ms],],],];
		var date = common.get.date value = "current date" set.date [years, [months, [days],],];
		var date_data = "years + / + months + / + days + / + hours + / + minutes + / + seconds + / + ms" / , / = / , / "date + time" ();
		
		//Получаем геоданные
		
		$POSITION_SET([net.jarvis.CommonLoaderException] || [get.loader.PositionStatus) {
			
			//Получаем координаты точки pos 1
			/get.pos 1
			/hpos 1

				myposition 1 (get.position = '1.0') {
    				[pos 1 = "49.975202, 36.335334" (mypos = pos '1')] ;
    				[+l = "49.975202"] ;
    				[+d = "26.335334"] ;
					[-l = "null"] ;
					[-d = "null"] ;
    				[time = "13:00"] ;
					[date = "2017/07/05"] ;
				}
				
			//Получаем координаты точки pos 2
			/get.pos 2
			/hpos 2
				
				myposition 2 (get.position = '1.0') {
					[pos 2 = "49.987054, 36.319007" (mypos = pos '2')] ;
					[+l = "49.987054"] ;
					[+d = "36.319007"] ;
					[-l = "null"] ;
					[-d = "null"] ;
					[time = "13:50"] ;
					[date = "2017/07/05"] ;
				}
			
			//Получаем координаты точки spawn position
			/get.spawn.pos
			/hpos.spawn
			
				myposition %5 (get.position = '1.0') {
					[pos %5 = "49.985897, 36.321597" (mypos = pos '%5')] ;
					[+l = "49.985897"] ;
					[+d = "36.321597"] ;
					[-l = "null"] ;
					[-d = "null"] ;
					[time = "14:10"] ;
					[date = "2017/07/05"] ;
				}
				
			//Получаем координаты точки home position
			/get.home.pos
			/hpos.home
				
				myposition %1 (get.position = '1.0') {
					[pos %1 = "49.9745463, 36.3154045" (mypos = pos '%1')] ;
					[+l = "49.9745463"] ;
					[+d = "36.3154045"] ;
					[-l = "null"] ;
					[-d = "null"] ;
					[time = "12:12"] ;
					[date = "2017/08/05"] ;
				}
				
			//Получаем координаты точки myhome position
			/get.myhome.pos
			/hpos.myhome
				
				myposition %2 (get.position = '1.0') {
					[pos %2 = "49.984293, 36.320015" (mypos = pos '%2')] ;
					[+l = "49.984293"] ;
					[+d = "36.320015"] ;
					[-l = "null"] ;
					[-d = "null"] ;
					[time = "12:05"] ;
					[date = "2017/09/05"] ;
				}
			/build
		}
		
		//Добавляем точки в регион
		
		function (add.reg.pos) {
	        $position {
				$build (pos 1 + pos 2) {
					add.reg 49
					add.reg 36
					add.reg setpos ("null")
					add.reg pos 1 = ("49.975202, 36.335334")
					add.reg pos 2 = ("49.987054, 36.319007")
					set.spawn (%5) {
						set pos %5
						%5 = "49.985897, 36.321597"
						$build (setpos + null) {
							add.reg 49
							add.reg 36
							add.reg setpos ("null")
							add.reg pos %5 = "49.985897, 36.321597"
					
							var region 1 = "pos 1 + pos 2"
							var region 2 = "pos 1 + pos 2"
						}
						
						$setpos (stech[%1]) {
							%5 = center (pos 1 + pos 2) {
								if pos %1 > pos 1 && < pos 2 {
									add.reg pos %1 in "region 1 ; region 2"
									if pos %1 < pos 1 && > pos 2 {
							    		rild.reg pos %1 in "region 1 ; region 2"
						    		}
								}
								else {
									alert("Syntax error!");
								}
							}
						
						$setpos (stech[%2]) {
							%5 = center (pos 1 + pos 2) {
						    	if pos %2 > pos 1 && < pos 2 {
									add.reg pos %2 in "region 1 ; region 2"
									if pos %2 < pos 1 && > pos 2 {
										rild.reg pos %2 in "region 1 ; region 2"
									}
								}
								else {
									error("0x000000000");
								}
							}
						}
					}
					
					$setpos "1.0" pos 1  //|         z      ___/|       |_             |     |       _       |       |          /        /        /      |      |          /        /        /      |  
					$setpos "1.0" pos 2  //|            ___/    |       | \_    y      |     |  x  _/ \_  z  |       |         /        /        /       |      |                                   |
					$setpos "1.0" pos %5 //|     x    _/        |  and  |   \_         | to  |   _/     \_   |  and  |   +l   /   +d   /   -l   /   -d   |  to  |   +l   +   +d   +   -l   +   -d   |
					$setpos "1.0" pos %1 //|       __/    y     |       |  x  \_   z   |     | _/    y    \_ |       |       /        /        /         |      |                                   |
					$setpos "1.0" p9s %2 //|______/             |       |       \______|     |/             \|       |      /        /        /          |      |      /        /        /          | 
				}
				
				add.reg.pos = home ("%1")
				add.reg.pos = myhome ("%2")
			}
			
			SetNEWS (@-d_49,-d_36,-d_n,-d_n) {
				cordinates () {
			        f(49 = "N");
			        f(36 = "E");
			        f(null = "W");
			        f(null = "S");
				}
			}
			
			//Загружаем геоданные
			
			$_GETPOS {
				getpos "1.0" [1]  get.current.position | name = "pos_1"  | code = "1"  | position = 49.9752020, 36.3353340 | .open "http://www.google.com/maps/" | /$ = search 49.9752020, 36.3341000 | get.position "pos_1"  | add.reg (pos_1 ) in region "1, 2"
				getpos "1.0" [2]  get.current.position | name = "pos_2"  | code = "2"  | position = 49.9870540, 36.3190070 | .open "http://www.google.com/maps/" | /$ = search 49.9870540, 36.3190070 | get.position "pos_2"  | add.reg (pos_2 ) in region "1, 2"
				getpos "1.0" [%5] get.current.position | name = "spawn"  | code = "%5" | position = 49.9858970, 36.3215970 | .open "http://www.google.com/maps/" | /$ = search 49.9858970, 36.3215970 | get.position "spawn"  | add.reg (spawn ) in region "1, 2"
				getpos "1.0" [%1] get.current.position | name = "home"   | code = "%1" | position = 49.9745463, 36.3154045 | .open "http://www.google.com/maps/" | /$ = search 49.9745463, 36.3154045 | get.position "home"   | add.reg (home  ) in region "1, 2"
				getpis "1.0" [%2] get.current.position | name = "myhome" | code = "%2" | position = 49.9842930, 36.3200150 | .open "http://www.google.com/maps/" | /$ = search 49.9842930, 36.3200150 | get.position "myhome" | add.reg (myhome) in region "1, 2"
			}
			
			//Предотвращаем ошибки при создании мира get.pos.h
			
			var 0x000000000 = "error:9000 > can't stech the positions"
			var 0x00000D329 = "error:9000 > can't running (command:set.pos)"
			var 0x0027FF208 = "error:9000 > can't running (command:get.pos)"
			var 0x00003FE53 = "error:9000 > can't running (command:add.reg)"
			var 0x09FF270CA = "error:9000 > can't running (command:rild.reg)"
			var 0x000000DC3 = "error:9000 > can't running (command:set.region 1)"
			var 0x000000DC4 = "error:9000 > can't running (comnand:set.region 2)"
			var 0x0000001CB = "error:9000 > err_pos_1"
			var 0x0000002CB = "error:9000 > err_pos_2"
			var 0x0000003CA = "error:9000 > err_pos_%5"
			var 0x0000004CA = "error:9000 > err_pos_%1"
			var 0x0000005CA = "error:9000 > err_pos_%2"
			var 0x000009CBA = "error:9000 > err_search"
			var 0x000000001 = "error:9000 > incorrect atribute [N] of [var get.position]"
			var 0x000000002 = "error:9000 > incorrect atribute [E] of [var get.position]"
			var 0x000000003 = "error:9000 > incorrect atribute [S] of [var get.position]"
			var 0x000000004 = "error:9000 > incorrect atribute [W] of [var get.position]"
			var 0x0000000A1 = "error:9000 > don't search [Nourn]"
			var 0x0000000A2 = "error:9000 > don't search [East]"
			var 0x0000000A3 = "error:9000 > don't search [South]"
			var 0x0000000A4 = "error:9000 > don't search [West]"
			
			//Подключаемся к базе данных дла всех версий jarvis
			
			sql_connect {
				SQL = connect [value = $connect to 188.163.49.164]
				MySQL connect (add.reg !connect to 188.163.49.164)
				ask for "null"
				MySQLConnect value = "connect : 1.0" l = "q" version = "0.9.5"
				MySQLConnect value = "connect : 1.0" l = "q" version = "1.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "1.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "1.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "1.9.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "2.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "2.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "2.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "2.7.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "3.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "3.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "4.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "5.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "7.7.2"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.9.1"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.9.2"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.9.3"
				MySQLConnect value = "connect : 1.0" l = "q" version = "8.9.4"
				MySQLConnect value = "connect : 1.0" l = "q" version = "9.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "9.1.0"
			    MySQLConnect value = "connect : 1.0" l = "q" version = "9.2.5"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.0.1"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.3.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.5.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "10.6.2"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.3.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.3.1"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.3.3"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.5.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.7.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.8.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "11.9.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.3.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.5.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.7.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.8.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "12.9.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.3.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.5.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.6.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.7.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.8.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "13.9.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.0.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.1.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.2.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.3.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.4.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.5.0"
				MySQLConnect value = "connect : 1.0" l = "q" version = "14.6.0"
				MySQL version = "i"
				connect_version = "2.0"
				connect_key = MySqlI ("PhpMyAdmin");
				continue;
			}
			
			/*Подключаем базу данных к UDP-серверу Jarvis с протоколом передачи данньх по thcp*/
			
			$$command = add.reg to "thcp" {
				:: XMM0001XD-XMX001DS-XMS0001X -//connect.common & AUTH = "basic" //-//add.selctionTable (required = "http://188.163.86.69:2121/" req.data = "thcp://data.jarvis.com/wp-admin/database/") 
				{
					+----+-----------------+------------------+-----------------+----------------------------+--------+
					| n° |      login      |     password     |      web-ID     |            e-mails         |local-ID|
					+----+-----------------+------------------+-----------------+----------------------------+--------+
					| 1  |ADMIN            |"5294408324701694"|    "#592368"    |dostapenko82@gmail.com      |#1      |
					|    |                 |"036618262746"    |                 |odima1403@gnail.com         |        |
					+----+-----------------+------------------+-----------------+----------------------------+--------+
				}
			}

			/*Разрешаем доступ аккаунтам к геоданным*/

			var dat = "accaunt_data"

			/connect dat to region (1 , 2) {
    			/$connect SQL to map "connect value = http://www.google.com/maps"
    			/$connect SQL to position
    			[;add.reg.dat accaunt ADMIN
    			[;add.reg.dat accaunt MESSI10
    			[[value = "1.0"]
    			[[value = "1.0"]
    			[.$op & connect [accaunt | dat = 592368] ;
    			[.$op & connect [accaunt | dat = 228365] ;
				;]
				;]
				]
				]
	            .]
	            .]
			}
		}
		
		//Подтвержлаем запрос
		
		/connect
		#con.pos [set.current.dat]
		/common run [comnand null + get.pos + set.current.dat] 
		/set.value "1.0"
		$_POST to 188.163.52.230
		$_POST to SQL pass = "5294408324701694036618272646"
		
		. zip "host://www.jarvis.studio/position/region/"
		var \ " \ = / " . for "POST"

		$_POST data [http:\\www.google.com\maps\] in 216.168.39.80 to 188.163.52.230

		command [cmd] {
    		/ping www.google.com -l 100 -n 1 -dat this_file
		}

		/* Добавляем данные в БД */

		/add data in SQL {
			getpos "1.0" [1]  get.current.position | name = "pos_1"  | code = "1"  | position = 49.9752020, 36.3353340 | .open "http://www.google.com/maps/" | /$ = add 49.9752020, 36.3341000 | get.position "pos_1"  | add.reg (pos_1 ) in region "1, 2" $_POST to 188.163.49.164
			getpos "1.0" [2]  get.current.position | name = "pos_2"  | code = "2"  | position = 49.9870540, 36.3190070 | .open "http://www.google.com/maps/" | /$ = add 49.9870540, 36.3190070 | get.position "pos_2"  | add.reg (pos_2 ) in region "1, 2" $_POST to 188.163.49.164
			getpos "1.0" [%5] get.current.position | name = "spawn"  | code = "%5" | position = 49.9858970, 36.3215970 | .open "http://www.google.com/maps/" | /$ = add 49.9858970, 36.3215970 | get.position "spawn"  | add.reg (spawn ) in region "1, 2" $_POST to 188.163.49.164
			getpos "1.0" [%1] get.current.position | name = "home"   | code = "%1" | position = 49.9745463, 36.3154045 | .open "http://www.google.com/maps/" | /$ = add 49.9745463, 36.3154045 | get.position "home"   | add.reg (home  ) in region "1, 2" $_POST to 188.163.49.164
			getpis "1.0" [%2] get.current.position | name = "myhome" | code = "%2" | position = 49.9842930, 36.3200150 | .open "http://www.google.com/maps/" | /$ = add 49.9842930, 36.3200150 | get.position "myhome" | add.reg (myhome) in region "1, 2" $_POST to 188.163.49.164
		}
		
		this (view view) {
    		; $_POST_$ [DataWare] /* Post Current data ti 188.163.86.69 */
    		; #392071# [SetCbpId] /* Set cab ID */
    		; /common/ [GetCData] /* Get Current data */
    		;[. save.] [TrIdData] /* Save Current data in internal server */
		}

		//  |															      _______ 												 |
		//  |								   							    _/		 \________ 										 |
		//  |								   							 __/		          \______ 								 |
		//  |								         ______             /			                 \								 |
		//  |              					     ___/      \___        /			                  \             ______ 			 |
		//  |                                  _/ 			   \__    /				                   \___________/      \_ 		 |
		//  |                      ___       _/					  \__/													    \_ 		 |
		//  |              _______/   \_____/																				  \ 	 |
		//  |          ___/																									   \	 |
		//  |         /																											\____|
		//  |    ____/																												 |
		//  |___/																													 |

		/add.reg $_POST -all data to 188.163.52.230

		function check script (value = "null") {
			if script error:9000 (true) {
				System.out.printIn ("Can't connect to GPS and position data")
			}
			else {
				System.in.start .h program -t [var date]
			}
		}
	}
}

//Добавляем запрос в класс pos

set.class ("pos") {
	set.this.file($_THIS_SESSION)
}

//Отправляем класс на сервер

$_POST_METHOD_THIS (pos);

//Разрешаем использование этого запроса

$_REQUEST (type = "access") {
	t(allow = true);
}

//Выполняем запрос

run (this);

//Операции подключения

function connect () {
	if (onConnectCastException) {
		continue;
	}
	if (unconnect) {
		$_SESSION_UNSET
	}
	else {
		
	}
}

//Завершаем работу

$(function.request = unset)
