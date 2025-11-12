/********************************
 Tester: Zain Ul Abidin
 University ID: 240174592
 Function: This function tests the divine() function implementation by Hatim.
********************************/

public class Zain_DivideTest {

    public static void main(String[] args) {
        Math mObj = new Math();
        int result = mObj.divide(20, 5);

        if(result == 4)
            System.out.println("Correct Implementation");
        else
            System.out.println("Error in Implementation");
    }
}