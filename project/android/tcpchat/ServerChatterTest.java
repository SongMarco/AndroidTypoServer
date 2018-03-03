package exam.chat;
import java.io.*;
import java.net.*;
import java.util.*;

//멀티 채팅의 서버
public class ServerChatterTest {

 public static void main(String[] args) {

  // 서버소켓 객체 선언
  ServerSocket serverSocket = null;
  Socket socket = null;

  //채팅룸 객체 생성
  ChatRoom room = new ChatRoom("Web & 스마트폰");

  //클라이언트 연결 임시 객체
  ServerChatter chatter = null;
  try{
   // 서버소켓 생성
   serverSocket = new ServerSocket(9003);
   while(true){
    room.display();

    System.out.println("***********클라이언트 접속 대기중*************");

    socket = serverSocket.accept();

    // 채팅 객체 생성
    chatter = new ServerChatter(socket, room);

    //쓰레드 작동시켜 1)로그인 처리 2)채팅 시작
    chatter.start();

    // 채팅 객체를 ArrayList에 저장한다.
    room.enterRoom(chatter);
   }
  }catch(IOException e){
   System.out.println(e.getMessage());
  }finally{
   try{
    serverSocket.close();
   }catch(IOException e){
   }
  }
 }
}

class ChatRoom{
 ArrayList<ServerChatter> chatters = new ArrayList<ServerChatter>();

 String name;
 public ChatRoom(String name){
  this.name = name;

 }
 public void display(){
  System.out.println("현재 접속자 정보 : 접속자 수 -> " + chatters.size());
  //현재 접속된 정보 확인 - 접속자수, 접속자 아이디 명단
  for(int i=0;i<chatters.size();i++){
   System.out.println(chatters.get(i).id);
  }
 }
 public void enterRoom(ServerChatter chatter){
  chatters.add(chatter);
 }
 //접속자들 모두에게 메세지 전달
 public void broadCasting(String message){
  ServerChatter chatter = null;

  for(int i=0;i<chatters.size();i++){
   chatter = chatters.get(i);
   chatter.sendMessage(message);
  }
 }
 //채팅에서 나갈때 처리
 public void exitRoom(ServerChatter chatter){
  boolean isDelete = chatters.remove(chatter);
  if( isDelete){
   System.out.println(chatter.id + " 클라이언트를 chatters에서 제거함");
  }
  else{
   System.out.println(chatter.id + " 클라이언트를 chatters에서 제거실패");
  }
 }
}


// 소켓을 이용하여 클라이언트 1개와 직접 연결되어 있다.
// ArrayList<> 인 chatters 에 소속되어있는 또다른 소켓과 데이타를 주고받는 쓰래드 클래스
class ServerChatter extends Thread{
 // 클라이언트와 직접 연결되어 있는 소켓
 Socket socket;
 BufferedReader br; // 소켓으로부터의 최종 입력 스트림
 PrintWriter pw;  // 소켓으로부터의 최종 출력 스트림

 // 현재 서버에 접속된 전체 클라이언트 정보가 저장되어 있다.
 ArrayList<ServerChatter> chatters;

 String id; // 아이디(별칭)--> 대화메세지에 보여질 id(대화명) ==> 로그인처리에 의해 구함
 boolean isLogin;
 ChatRoom room;

 public ServerChatter(Socket socket, ChatRoom room){
  this.socket = socket;
  this.room = room;

  // 소켓으로부터 최종 입출력 스트림 얻기
  try{
   br = new BufferedReader(new InputStreamReader(socket.getInputStream()));
   pw = new PrintWriter(socket.getOutputStream());
  }catch(IOException e){
   System.out.println(e.getMessage());
  }
 }

 // 대화명을 입력받는 처리 --> 확장되어지면 데이타베이스에 id/pass 를 검색하여
 //         로그인 기능으로 확장할 수 있다.
 public void login(){

  String members[] = {"강아지","송아지","고양이"}; //접속 가능한 아이디가 3개만 존재한다고 가정한다.
  String tempId = null;

  try{
   while(true){
    tempId = br.readLine();
    boolean isOk = false;

    for(int i=0;i<members.length;i++){
     if(tempId.equals(members[i])){
      isOk = true;
     }
    }
    if(isOk){
     this.id = tempId;
     this.isLogin = true;
     sendMessage("ok");
     System.out.println("서버 - 로그인 이름 확인");
     break;
    }
    else {
     sendMessage("error");
     System.out.println("서버 - 로그인 이름 XXX");
    }
   }
  }catch(IOException e){
   System.out.println(e.getMessage());
   System.out.println("login()처리에서 예외 발생.....");
  }
 }


 public void run(){
  login();  //로그인 처리
  if(!isLogin){return;} //chatters 에서 자신을 제거하고 소켓을 닫는다.
  try{
   String message = "";
            while(!message.equals("bye")){
             System.out.println(id +" 클라이언트가 메세지를 기다립니다.");
             message = br.readLine();
             System.out.println("받은 메세지 ==>" + id + ":" + message);

             if(message.equals("bye")){
              room.broadCasting(id+"님이 퇴장하셨습니다.");}
             room.broadCasting(id+" : "+message);
             }
  }catch(IOException e){
   System.out.println(e.getMessage());
   System.out.println("메세지를 수신하여 송신중 예외 발생....");
  }finally{
   room.exitRoom(this);
   close();
   System.out.println("연결을 닫고 쓰레드 종료....");
  }
 }
 //메세지를 보내는 메소드
 void sendMessage(String message){
  try{
   pw.println(message);
   pw.flush();
  }catch(Exception e){
   System.out.println(e.getMessage());
   System.out.println("sendMessage()에서 예외 발생....");
  }
 }

 public void close(){
  try{
   br.close();
   pw.close();
   socket.close();
  }catch(Exception e){
   System.out.println("close()..도중 예외 발생!");
  }
 }
}
