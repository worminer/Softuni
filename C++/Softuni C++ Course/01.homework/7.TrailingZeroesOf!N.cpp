#include <iostream>
using namespace std;

int main() {
    int n, counter = 0;
    unsigned long long number = 1;
    cout << "write a number up to 50:" << endl;
    cin >> n;

    for(int i = 1; i <= n; i++){
        number *= i;
    }
    while (number % 10 == 0){
        counter++;
        number /= 10;
    }

    cout << counter << endl;

    return 0;
}

