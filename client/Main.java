package base;

import java.awt.GraphicsDevice;
import java.awt.GraphicsEnvironment;

public class Main {
	public static void main(String[] args) {
		boolean connencted = false;
		do {
			try {
				System.out.println("Trying to connect...");
				if (PhpCaller.callphp().charAt(0)==('m')) {
					connencted = true;
				}
			} catch (Exception e1) {
				connencted = false;
			}
		} while (!connencted);

		System.out.println("Downloading new pictures...");
		TPDatabase tpdb = new TPDatabase("database1");
		System.out.println("Done! Starting...");
		GraphicsEnvironment env = GraphicsEnvironment
				.getLocalGraphicsEnvironment();
		GraphicsDevice[] devices = env.getScreenDevices();
		GUI gui = null;
		try {
			gui = new GUI(devices[0], tpdb);
		} catch (Exception e) {
			e.printStackTrace();
		}
		gui.initComponents(gui.getContentPane());
		gui.begin();

	}
}
