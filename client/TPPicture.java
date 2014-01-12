package base;

import java.io.Serializable;
import java.text.SimpleDateFormat;
import java.util.Date;

public class TPPicture implements Comparable<TPPicture>, Serializable {
	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private String info;
	private String path;
	private String owner;
	private String date;
	private int id;
	private static final SimpleDateFormat std = new SimpleDateFormat(
			"yyyy-MM-dd HH:mm:ss");

	public TPPicture(String info, String path, String date, String owner, int id) {
		this.id = id;
		this.owner = owner;
		this.info = info;
		this.path = path;
		this.date = std.format(new Date(Long.parseLong(date)*1000));
	}

	public String getOwner() {
		return owner;
	}
	public void setInfo(String info){
		this.info = info;
	}

	@Override
	public int hashCode() {
		return Integer.hashCode(id);
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		TPPicture other = (TPPicture) obj;
		if (id != other.id)
			return false;
		return true;
	}

	public String getInfo() {
		return info;
	}

	public String getPath() {
		return path;
	}

	public String getDate() {

		return date;
	}

	public int getId() {
		return id;
	}

	@Override
	public int compareTo(TPPicture pic) {
		return id - pic.id;
	}
}
