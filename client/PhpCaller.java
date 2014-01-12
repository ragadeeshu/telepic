package base;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

public class PhpCaller {
	public static final String TPURL = "http://telepic.yoururl.com/";
	public static final String USERNAME = "client_username";
	public static final String PASSWORD = "client_password";
	public static final int SERVERPATH = 0;
	public static final int OWNER = 1;
	public static final int DESCRIPTION = 2;
	public static final int DATE = 3;
	public static final int MAX_HEIGHT = 800;

	public static String callphp() throws Exception {
		String urlParameters = "myVariable1=myValue1&myVariable2=myValue2";

		HttpURLConnection connection = null;

		URL url = new URL(TPURL + "clientConnect.php");
		connection = (HttpURLConnection) url.openConnection();

		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type",
				"application/x-www-form-urlencoded");

		connection.setRequestProperty("Content-Length",
				"" + Integer.toString(urlParameters.getBytes().length));
		connection.setRequestProperty("Content-Language", "en-US");

		connection.setUseCaches(false);
		connection.setDoInput(true);
		connection.setDoOutput(true);

		DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();

		InputStream is = connection.getInputStream();
		BufferedReader rd = new BufferedReader(new InputStreamReader(is));
		String line;
		StringBuffer response = new StringBuffer();
		while ((line = rd.readLine()) != null) {
			response.append(line);
			response.append('\r');
		}
		rd.close();
		return response.toString();
	}

	public static ArrayList<Integer> getIDs() throws Exception {
		ArrayList<Integer> ids = new ArrayList<Integer>();
		String urlParameters = "username=" + USERNAME + "&password=" + PASSWORD;
		HttpURLConnection connection = null;

		URL url = new URL(TPURL + "getPictureIds.php");
		connection = (HttpURLConnection) url.openConnection();

		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type",
				"application/x-www-form-urlencoded");

		connection.setRequestProperty("Content-Length",
				"" + Integer.toString(urlParameters.getBytes().length));
		connection.setRequestProperty("Content-Language", "en-US");

		connection.setUseCaches(false);
		connection.setDoInput(true);
		connection.setDoOutput(true);

		DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();

		InputStream is = connection.getInputStream();
		BufferedReader rd = new BufferedReader(new InputStreamReader(is));
		String line;

		while ((line = rd.readLine()) != null) {
			ids.add(Integer.parseInt(line));
		}
		rd.close();
		return ids;
	}

	public static String[] getInfo(int id) throws Exception {
		String[] info = new String[4];
		String urlParameters = "username=" + USERNAME + "&password=" + PASSWORD
				+ "&id=" + id;
		HttpURLConnection connection = null;

		URL url = new URL(TPURL + "/getPictureInfo.php");
		connection = (HttpURLConnection) url.openConnection();

		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type",
				"application/x-www-form-urlencoded");

		connection.setRequestProperty("Content-Length",
				"" + Integer.toString(urlParameters.getBytes().length));
		connection.setRequestProperty("Content-Language", "en-US");

		connection.setUseCaches(false);
		connection.setDoInput(true);
		connection.setDoOutput(true);

		DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();

		InputStream is = connection.getInputStream();
		BufferedReader rd = new BufferedReader(new InputStreamReader(is,
				"utf-8"));
		String line;
		int i = 0;
		while ((line = rd.readLine()) != null && i < 4) {
			info[i] = line;
			i++;
		}
		rd.close();
		return info;
	}

	public static String downloadImage(String path) throws Exception {
		String urlParameters = "username=" + USERNAME + "&password=" + PASSWORD
				+ "&h="+MAX_HEIGHT+"&file=" + URLEncoder.encode(path, "UTF-8");
		HttpURLConnection connection = null;

		URL url = new URL(TPURL + "getPictureById.php");
		connection = (HttpURLConnection) url.openConnection();

		connection.setRequestMethod("POST");
		connection.setRequestProperty("Content-Type",
				"application/x-www-form-urlencoded");

		connection.setRequestProperty("Content-Length",
				"" + Integer.toString(urlParameters.getBytes().length));
		connection.setRequestProperty("Content-Language", "en-US");

		connection.setUseCaches(false);
		connection.setDoInput(true);
		connection.setDoOutput(true);

		DataOutputStream wr = new DataOutputStream(connection.getOutputStream());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();

		InputStream in = new BufferedInputStream(connection.getInputStream());
		ByteArrayOutputStream out = new ByteArrayOutputStream();
		byte[] buf = new byte[1024 * 16];
		int n = 0;
		while (-1 != (n = in.read(buf))) {
			out.write(buf, 0, n);
		}
		out.close();
		in.close();
		byte[] response = out.toByteArray();
		String[] split = path.split("/");
		File pathFile = new File(split[split.length - 2] + "/");
		pathFile.mkdirs();
		String returnPath = split[split.length - 2] + "/"
				+ split[split.length - 1];
		FileOutputStream fos = new FileOutputStream(split[split.length - 2]
				+ "/" + split[split.length - 1]);
		fos.write(response);
		fos.close();
		return returnPath;
	}
}
