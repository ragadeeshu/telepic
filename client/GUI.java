package base;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Container;
import java.awt.FlowLayout;
import java.awt.Font;
import java.awt.GraphicsDevice;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.ImageIcon;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextArea;

@SuppressWarnings("serial")
public class GUI extends JFrame implements KeyListener {

	private GraphicsDevice device;
	private TPDatabase db;
	private boolean isFullScreen = false;

	private JTextArea currentInfo;
	private BufferedImage myPicture;
	private JLabel picLabel;
	private JLabel owner;
	private JLabel date;
	private static final Font LARGE_FONT = new Font("Verdana", Font.PLAIN, 48);
	private static final Font SMALL_FONT = new Font("Verdana", Font.PLAIN, 30);

	public GUI(GraphicsDevice device, TPDatabase tpdb) {
		super(device.getDefaultConfiguration());

		this.device = device;
		setTitle("Telepic");
		db = tpdb;
		setDefaultCloseOperation(EXIT_ON_CLOSE);
		addKeyListener(this);

	}

	private void changeInfo(TPPicture pic) {
		currentInfo.setText(pic.getInfo());
		owner.setText("Picture is from " + pic.getOwner());
		date.setText("Picture added on: " + pic.getDate());
		try {
			myPicture = ImageIO.read(new File(pic.getPath()));
		} catch (IOException e) {
			e.printStackTrace();
		}
		picLabel.setIcon(new ImageIcon(myPicture));

	}

	void initComponents(Container c) {
		c.setBackground(Color.BLACK);
		date= new JLabel();
		owner = new JLabel();
		date.setFont(SMALL_FONT);
		owner.setFont(SMALL_FONT);
		currentInfo = new JTextArea();
		currentInfo.setEditable(false);
		currentInfo.setRows(3);
		currentInfo.setFont(LARGE_FONT);
		picLabel = new JLabel();
		currentInfo.setLineWrap(true);
		currentInfo.setWrapStyleWord(true);
		changeInfo(db.getNext());
		setContentPane(c);
		
		c.setLayout(new BorderLayout());

		JPanel currentPanel = new JPanel(new BorderLayout());
		JPanel centeringPanel = new JPanel(new FlowLayout(FlowLayout.CENTER));
		centeringPanel.setBackground(Color.BLACK);
		((FlowLayout)centeringPanel.getLayout()).setVgap(0);
		c.add(centeringPanel, BorderLayout.NORTH);
		centeringPanel.add(picLabel);
		c.add(currentPanel, BorderLayout.SOUTH);
		JPanel infoPanel = new JPanel(new BorderLayout());
		currentPanel.add(currentInfo,BorderLayout.CENTER);
		currentPanel.add(infoPanel, BorderLayout.NORTH);
		infoPanel.add(owner, BorderLayout.WEST);
		infoPanel.add(date, BorderLayout.EAST);
		
		changeInfo(db.getNext());

		
		currentPanel.addKeyListener(this);
		currentInfo.addKeyListener(this);
		currentPanel.requestFocus();

	
	}

	public void begin() {
		isFullScreen = device.isFullScreenSupported();
		setUndecorated(isFullScreen);
		setResizable(!isFullScreen);
		if (isFullScreen) {
			device.setFullScreenWindow(this);
			validate();
		} else {
			pack();
			setVisible(true);
		}
	}

	@Override
	public void keyPressed(KeyEvent arg0) {
		int keyCode = arg0.getKeyCode();
		if (keyCode == 37 || keyCode == 100 || keyCode == 155 || keyCode == 96) {
			changeInfo(db.getNext());
		} else if (keyCode == 39 || keyCode == 102 || keyCode == 10) {
			changeInfo(db.getPrevious());
		}
	}

	@Override
	public void keyReleased(KeyEvent arg0) {

	}

	@Override
	public void keyTyped(KeyEvent arg0) {
	}

}
