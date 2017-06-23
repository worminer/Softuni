#include <iostream>
using namespace std;

int reverseDecimal(int num) {
    int new_num = 0;
    while(num > 0)
    {
            new_num = new_num*10 + (num % 10);
            num = num/10;
    }
    return new_num;
}

int main() {
    int  n,expected ;
    string result = "false";
    cout << "write number :" << endl;
    cin >> n ;
    cout << "expected result :" << endl;
    cin >> expected;

    n = reverseDecimal(n);

    if (n == expected) {
        result = "true";
    }

    cout << result << endl;
    return 0;
}
