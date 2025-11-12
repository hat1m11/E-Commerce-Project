public class Hatim_Test{

    /********************************
    Tester: Hatim Qazi Haider Hussain
     University ID: 240204258
    Function: This function tests the subtract() function implementation by Yusuf.
    ********************************/

   
    public static void main(String[] args) {
        Math math = new Math();
        int result = math.subtract(10, 5);
        if (result == 5) {
            System.out.println("Test passed: subtract(10, 5) returned 5");
        } else {
            System.out.println("Test failed: subtract(10, 5) returned " + result);
        }
    }

}