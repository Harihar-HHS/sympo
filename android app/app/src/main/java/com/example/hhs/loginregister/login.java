package com.example.hhs.loginregister;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class login extends AppCompatActivity {

    TextView uid,lgin_pswd;
    Button lgin;
    String uid_mobile,login_pswd;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        uid=findViewById(R.id.uid);
        lgin_pswd=findViewById(R.id.login_pswd);
        lgin=findViewById(R.id.login_btn);

        lgin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                uid_mobile=uid.getText().toString();
                login_pswd=lgin_pswd.getText().toString();
            }
        });
    }
}
