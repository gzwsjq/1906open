<center><font style="color:red">用户注册</font></center>

<center>
<form action="{{url('/regdo')}}" method="post" enctype="multipart/form-data">
    @csrf
    <table>
        <tr>
            <td>公司名: </td>
            <td><input type="text" name="corp"><br></td>
        </tr>
        <tr>
            <td> 法人:</td>
            <td><input type="text" name="person"><br></td>
        </tr>
        <tr>
            <td> 营业执照: </td>
            <td> <input type="file" name="scope"><br></td>
        </tr>
        <tr>
            <td>联系人电话:</td>
            <td><input type="text" name="tel"><br></td>
        </tr>
        <tr>
            <td> EMAIL:</td>
            <td><input type="text" name="email"><br></td>
        </tr>
        <tr>
            <td>密码:</td>
            <td><input type="text" name="pass"><br></td>
        </tr>
        <tr>
            <td>确认密码:</td>
            <td><input type="text" name="pass1"><br></td>
        </tr>
        <tr>
            <td> 公司地址:</td>
            <td> <input type="text" name="address"><br></td>
        </tr>
        <tr>
            <td> </td>
            <td><button>注册</button></td>
        </tr>
    </table>
</form>
</center>