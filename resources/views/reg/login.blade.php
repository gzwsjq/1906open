<center><font style="color:red">用户登录</font></center>

<center>
    <form action="{{url('/logindo')}}" method="post">
        @csrf
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="name"><br></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="text" name="pass"><br></td>
            </tr>
            <tr>
                <td> </td>
                <td><button>登录</button></td>
            </tr>
        </table>
    </form>
</center>