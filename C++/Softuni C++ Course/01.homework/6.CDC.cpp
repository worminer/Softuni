#include <iostream>
using namespace std;

int main() {
    int a,b,c;
    cin >> a >> b;
    if ( b == 0 )
        cout << "CDC is : " << a << endl;

    else
        while ( b != 0 )
        {
            c = b;
            b = a % b;
            a = c;
        }

        cout << "CDC is : " <<  a << endl;
    return 0;
}

