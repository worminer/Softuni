 #include<iostream>
 #include <cmath>
using namespace std;

int main() {
    int a, b ,c;

    cin >> a >> b >> c;

    if (a == 0)
    {
        cout<< "This is not an quadratic equation!" << endl;
    } else {
        double discriminant = (b * b) - (4 * a * c);
            if (discriminant > 0)
            {
                double x1 = (-b + sqrt(discriminant)) / (2 * a);
                double x2 = (-b - sqrt(discriminant)) / (2 * a);
                cout<< "The equation roots are: nX1: "<< x1 <<" nX2: " << x2 << endl;

            } else if (discriminant == 0)
            {
                double x = -b / (2 * a);
                cout<< "The equaltion has only one root: "<< x << endl;

            } else if (discriminant < 0)
            {
                cout<< "This equations doesn't have solution!" << endl;

            }
    }
    return 0;
}
