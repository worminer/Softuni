#include<iostream>
using namespace std;

int main() {
    /* i dont understand what this task want from be but anyway..*/
    int negativeCounter = 0,positiveCounter = 0;
    float a,b,c;
    char sign = '-';
    cin >> a >> b >> c;


    if(a < 0){
        negativeCounter++;
    }

    if(b < 0){
        negativeCounter++;
    }

    if(c < 0){
        negativeCounter++;
    }

    if (negativeCounter % 2 == 0){
        sign = '+';
    }
    cout << "sign is:"<< sign << endl;




}

