<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Todo List</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> <!-- google font -->
    <style media="screen">
      .btn {
        text-decoration: none;
        font-size:2rem;
        color:white;
        padding:10px 20px 10px 20px;
        margin:20px;
        display:inline-block;
        border-radius: 10px;
        transition:all 0.1s;
        text-shadow: 0px -2px rgba(0, 0, 0, 0.44);
        font-family: 'Lobster', cursive; <!-- google font -->
      }
      .btn:active{
        transform: translateY(3px);
      }
      .btn.blue{
        background-color: #1f75d9;
        border-bottom:5px solid #165195;
      }
      .btn.blue:active{
        border-bottom:2px solid #165195;
      }
      .content {
        color: red;
      }
    </style>
  </head>
  <body>
    <div>
      <header>
        <blockquote>
          <p>< 만들면서 배우는 CodeIgniter ></p>
        </blockquote>
      </header>
      <nav>  <!-- 다른페이지의 링크에 사용. 메뉴, 목차 등등 -->
        <ul>
          <li><a rel="help" href="/todo/index.php/main/lists">todo 애플리케이션 프로그램</a> </li>
        </ul>
      </nav>
