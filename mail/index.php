<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �������");
?>

<div class="mailadmin">

<div class="mailtitle">���� �������</div>
	<input type="text" id="mailtopick"/>
	
	<div class="mailtitle">��������</div>
	<textarea id="introduction"  placeholder="������� �����"></textarea>
<hr/>

<div class="hideit">
	<div class="work" id="etwork">
			<table>
				<tr>
					<td>��������</td>
					<td><input type="text" id="tname" /></td>
				</tr>
				<tr>
					<td>������</td>
					<td><input type="text" id="tlink" /></td>
				</tr>
				<tr>
					<td>���������</td>
					<td><textarea id="tintr"></textarea></td>
				</tr>
			</table>
		</div>
</div>

<div class="topics" id="234">
	<div class="topic" id="topic1">
		<div class="name">���� 1</div>
		<div class="work">
			<table>
				<tr>
					<td>��������</td>
					<td><input type="text" id="tname" /></td>
				</tr>
				<tr>
					<td>������</td>
					<td><input type="text" id="tlink" /></td>
				</tr>
				<tr>
					<td>���������</td>
					<td><textarea id="tintr"></textarea></td>
				</tr>
			</table>
		</div>	
		<span class="deltopic"><a href="javascript:delltopic(1);"  id="del0">������� ����</a></span>

	</div>
</div>
			<span class="addtopic"><a href="javascript:addtopic();">�������� ����</a></span><br/><br/>
<hr/>	
	<div class="mailtitle">����������</div>
	<textarea id="conclusion" placeholder="������� �����"></textarea>
	<div class="mailfooter">
	<a href="javascript:savetopics();">���������</a>
	</div>
	
<div class="saveok"></div>

<div class="errors"></div>

</div>	


<script>
count=1;
	function addtopic () {
		count++;		
		$('.topics').append("<div class='topic' id='topic"+count+"'><div class='name'>���� "+count+"</div></div>");
		$('#etwork').clone().appendTo('#topic'+count);
		$('#topic'+count).append('<span class="deltopic"><a href="javascript:delltopic('+count+');" id="del'+count+'">������� ����</a></span>');
		/*$('#topic'+count).append('<span class="addtopic"><a href="javascript:addtopic();">�������� ����</a></span>');*/
	}
	
	function delltopic(id) {
	$("#topic"+id).remove();
	}
	
	function savetopics () {
	
	//������� ������
	$(".errors").html("");
	err=0;
	
		
		data="";
		
		if ($("#introduction").val()==""){$(".errors").append("�� ��������� ��������<br/>");err++;}
		if ($("#conclusion").val()==""){$(".errors").append("�� ��������� ����������<br/>");err++;}
		if ($("#mailtopick").val()==""){$(".errors").append("�� ��������� ���� ��������<br/>");err++;}
		//��������		
		data+="introduction="+$("#introduction").val();
		//����������
		data+="&conclusion="+$("#conclusion").val();
		//���� �������
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
							//��������� �� ������
							next=i+1;
							$(".errors").append("���� "+i+" �� ��� ���� ���������<br/>");
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
			$(".saveok").append( "������ ������� ��������");	
			}
			else
			{	
				$(".errors").append( "������ ����������: <br/>"+ msg);			
			}
			}
			});
	}
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>