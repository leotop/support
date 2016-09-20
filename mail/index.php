<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание выпуска");
?>

<div class="mailadmin">

<div class="mailtitle">Тема выпуска</div>
	<input type="text" id="mailtopick"/>
	
	<div class="mailtitle">Введение</div>
	<textarea id="introduction"  placeholder="Введите текст"></textarea>
<hr/>

<div class="hideit">
	<div class="work" id="etwork">
			<table>
				<tr>
					<td>Название</td>
					<td><input type="text" id="tname" /></td>
				</tr>
				<tr>
					<td>Ссылка</td>
					<td><input type="text" id="tlink" /></td>
				</tr>
				<tr>
					<td>Аннотация</td>
					<td><textarea id="tintr"></textarea></td>
				</tr>
			</table>
		</div>
</div>

<div class="topics" id="234">
	<div class="topic" id="topic1">
		<div class="name">Тема 1</div>
		<div class="work">
			<table>
				<tr>
					<td>Название</td>
					<td><input type="text" id="tname" /></td>
				</tr>
				<tr>
					<td>Ссылка</td>
					<td><input type="text" id="tlink" /></td>
				</tr>
				<tr>
					<td>Аннотация</td>
					<td><textarea id="tintr"></textarea></td>
				</tr>
			</table>
		</div>	
		<span class="deltopic"><a href="javascript:delltopic(1);"  id="del0">Удалить тему</a></span>

	</div>
</div>
			<span class="addtopic"><a href="javascript:addtopic();">Добавить тему</a></span><br/><br/>
<hr/>	
	<div class="mailtitle">Заключение</div>
	<textarea id="conclusion" placeholder="Введите текст"></textarea>
	<div class="mailfooter">
	<a href="javascript:savetopics();">Сохранить</a>
	</div>
	
<div class="saveok"></div>

<div class="errors"></div>

</div>	


<script>
count=1;
	function addtopic () {
		count++;		
		$('.topics').append("<div class='topic' id='topic"+count+"'><div class='name'>Тема "+count+"</div></div>");
		$('#etwork').clone().appendTo('#topic'+count);
		$('#topic'+count).append('<span class="deltopic"><a href="javascript:delltopic('+count+');" id="del'+count+'">Удалить тему</a></span>');
		/*$('#topic'+count).append('<span class="addtopic"><a href="javascript:addtopic();">Добавить тему</a></span>');*/
	}
	
	function delltopic(id) {
	$("#topic"+id).remove();
	}
	
	function savetopics () {
	
	//Очищаем ошибки
	$(".errors").html("");
	err=0;
	
		
		data="";
		
		if ($("#introduction").val()==""){$(".errors").append("Не заполнено введение<br/>");err++;}
		if ($("#conclusion").val()==""){$(".errors").append("Не заполнено заключение<br/>");err++;}
		if ($("#mailtopick").val()==""){$(".errors").append("Не заполнена тема рассылки<br/>");err++;}
		//Введение		
		data+="introduction="+$("#introduction").val();
		//Заключение
		data+="&conclusion="+$("#conclusion").val();
		//Тема выпуска
		data+="&mailtopick="+$("#mailtopick").val();
		
		
		number=1;
		imp=0;
		dat="";
		 for (i=0; i<=count;i++)
		 {
				imp=0;
				dat="";
				var div = document.getElementById('topic'+i)
				if (div)
				{
					var elems = div.getElementsByTagName('*')
					if (elems)
					for(var q=0; q<elems.length; q++)
					{
						switch (elems[q].id)
						{
						case "tname": if (elems[q].value!=""){ dat+="&tname"+number+"="+elems[q].value; imp++;} break;
						case "tlink": if (elems[q].value!=""){ dat+="&tlink"+number+"="+elems[q].value; imp++;} break;
						case "tintr": if (elems[q].value!=""){ dat+="&tintr"+number+"="+elems[q].value; imp++;} break;
						}
						
						
					}
					if (imp==3)
						{	
							data+=dat;
						}
						else
						{
							//Сообщение об ошибке
							next=i+1;
							$(".errors").append("Тема "+i+" Не все поля заполнены<br/>");
							err++;
						}
					number++;
				}
		 }
		 number--;
		 data+="&count="+number;
		 if (err==0)
			$.ajax({
			type: "POST",
			url: "/mail/save.php",
			data: data,
			success: function(msg){
			if (msg==1){
			$(".saveok").html("");			
			$(".saveok").append( "Выпуск успешно сохранен");	
			}
			else
			{	
				$(".errors").append( "Ошибка сохранения: <br/>"+ msg);			
			}
			}
			});
	}
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>