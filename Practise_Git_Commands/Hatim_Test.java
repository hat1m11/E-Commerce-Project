/********************************
 Tester: Hatim Qazi Haider Hussain
 University ID: 240204258
 Function: This function tests the divide() function implementation by Zain.
********************************/

public class Hatim_DivideTest {

    public static void main(String[] args) {
        Math mObj = new Math();
        int result = mObj.divide(20, 5);

        if(result == 4)
            System.out.println("Correct Implementation");
        else
            System.out.println("Error in Implementation");
    }
}